<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Document Upload and QR Code Generation

This Laravel application provides a comprehensive solution for handling document uploads. It includes functionality for validating files, extracting their contents, saving data to a database, and generating QR codes with document details.

## Features

- **Complete Workflow**: Manages the entire process from document upload to QR code generation.
- **File Validation**: Ensures only valid file types and sizes are accepted, enhancing security and data integrity.
- **QR Code Generation**: Creates a QR code containing document details for quick reference.
- **Library Integration**: Utilizes libraries such as `Smalot\PdfParser` for PDF content extraction and `SimpleSoftwareIO\QrCode` for QR code creation.
- **Modular Design**: Features modular code with separate methods for easier maintenance and testing.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/riyajosef/document-upload.git
   ```

2. Navigate to the project directory:
   ```bash
   cd document-upload
   ```

3. Install dependencies using Composer:
   ```bash
   composer install
   ```

4. Set up your `.env` file by copying the example file:
   ```bash
   cp .env.example .env
   ```

5. Generate an application key:
   ```bash
   php artisan key:generate
   ```

6. Run the database migrations:
   ```bash
   php artisan migrate
   ```

7. Serve the application:
   ```bash
   php artisan serve
   ```

## Usage

To upload a document, send a POST request to `/upload` with the document file. The endpoint will handle file validation, extract content, save data to the database, and generate a QR code with document details.

### Example Request

```bash
curl -X POST -F "document=@/path/to/your/document.pdf" http://localhost:8000/upload
```

### Example Response

```json
{
    "message": "Document uploaded successfully!",
    "qr_code": "<QR_CODE_IMAGE_BASE64>"
}
```

## Libraries Used

- **`Smalot\PdfParser`**: For extracting text from PDF documents.
- **`SimpleSoftwareIO\QrCode`**: For generating QR codes.

## Contributing

Feel free to submit issues or pull requests. Contributions are welcome!
