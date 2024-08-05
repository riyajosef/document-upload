<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Product;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        /*
         * document type validation
        */
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('documents');

        $data = $this->parseDocument(storage_path('app/' . $filePath));

        // Generate a unique token number
        $token_number = $this->generateUniqueToken();

        $document = Document::create([
            'manufacturer_name' => $data['manufacturer_name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'date' => $data['date'],
            'token_number' => $token_number,
        ]);

        foreach ($data['products'] as $product) {
            Product::create(array_merge($product, ['document_id' => $document->id]));
        }

        $qrCode = QrCode::size(250)->generate("Manufacturer: {$data['manufacturer_name']}, Address: {$data['address']}, Phone: {$data['phone']}, Email: {$data['email']}, Date: {$data['date']}, Token: {$document->token_number}");

        return response()->json(['message' => 'Document uploaded and processed successfully', 'qr_code' => $qrCode]);
    }

    private function generateUniqueToken()
    {
        do {
            $token = Str::random(10);
        } while (Document::where('token_number', $token)->exists());

        return $token;
    }


    private function parseDocument($filePath)
{
    $pdfParser = new \Smalot\PdfParser\Parser();
    $pdf = $pdfParser->parseFile($filePath);
    $text = $pdf->getText();
    $lines = explode("\n", $text);

     // Extract header information
     $manufacturer_name = trim($lines[0]);
     $address = trim($lines[1]);
     $phone = trim($lines[2]);
     $email = trim($lines[3]);
     $date = trim($lines[4]);

    /*
    * Extract data from the text (this requires custom parsing logic depending on document structure)
    * For simplicity, this example assumes that text extraction and parsing logic is implemented
    */
   
    $products = [];
    for ($i = 5; $i < count($lines); $i++) {
        $productData = explode('|', trim($lines[$i]));
        if (count($productData) == 7) {
            $products[] = [
                'sl_no' => $productData[0],
                'product_name' => $productData[1],
                'quantity' => (int)$productData[2],
                'price' => (float)$productData[3],
                'mrp' => (float)$productData[4],
                'expiry_date' => $productData[5],
                'manufacturing_date' => $productData[6],
            ];
        }
    }

    return [
        'manufacturer_name' => $manufacturer_name,
        'address' => $address,
        'phone' => $phone,
        'email' => $email,
        'date' => $date,
        'products' => $products,
    ];
}



}
