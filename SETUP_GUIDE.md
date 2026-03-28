# Image Management System Setup Guide

## Prerequisites
- XAMPP (or any PHP + MySQL environment)
- PHP 7.0+
- MySQL 5.7+

## Installation Steps

### 1. **Create Database**
Open phpMyAdmin (http://localhost/phpmyadmin) and create a new database:
```sql
CREATE DATABASE sofiya_db;
```

### 2. **Configure Database Connection**
Edit `backend/config.php` and update the credentials:
```php
define('DB_HOST', 'localhost');   // Your MySQL host
define('DB_USER', 'root');        // Your MySQL user
define('DB_PASS', '');            // Your MySQL password
define('DB_NAME', 'sofiya_db');   // Your database name
```

### 3. **Install TCPDF Library**

The TCPDF library is required for PDF generation. You have two options:

#### Option A: Use TCPDF via Composer (Recommended)
```bash
cd c:\xampp7\htdocs\sofiya-adminlte
composer require tecnickcom/tcpdf
```

This will install TCPDF in a `vendor` folder. Then update the path in `backend/generate_pdf.php`:
```php
require_once '../../vendor/autoload.php';
$pdf = new TCPDF();
```

#### Option B: Manual Installation
1. Download TCPDF from https://tcpdf.org/
2. Extract and place the folder in `plugins/tcpdf`
3. The script will already reference this location

### 4. **Create Uploads Directory**
The `backend/uploads` directory is automatically created by the upload script, but you can create it manually:
```bash
mkdir backend/uploads
chmod 755 backend/uploads
```

### 5. **Access the Application**
Open in your browser:
```
http://localhost/sofiya-adminlte/input.php
```

## Features

✅ **Upload Images** - Upload image with title and date
✅ **Store in MySQL** - All images stored securely in database
✅ **Display Gallery** - View uploaded images in a responsive grid
✅ **Delete Images** - Remove images from database and server
✅ **Generate PDF Report** - Create professional PDF with all images arranged in a 2x2 grid

## File Structure

```
backend/
├── config.php              # Database configuration
├── upload_image.php        # Handle image uploads
├── get_images.php          # Retrieve images from DB
├── delete_image.php        # Delete images
├── generate_pdf.php        # Generate PDF report using TCPDF
└── uploads/               # Folder for uploaded images (auto-created)
```

## Database Schema

The system automatically creates the `images` table with the following structure:
```sql
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image_date DATE NOT NULL,
    image_filename VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

## Troubleshooting

### Error: "Database connection failed"
- Check if MySQL is running
- Verify database credentials in `config.php`
- Ensure the database exists

### Error: "TCPDF library not found"
- Install TCPDF using one of the methods above
- Verify the installation path matches in `generate_pdf.php`

### Images not uploading
- Check that `backend/uploads` directory exists and has write permissions
- Verify file size is under 5MB
- Only image formats (jpg, jpeg, png, gif, webp) are allowed

### PDF not generating
- Ensure all images exist in `backend/uploads/`
- Check TCPDF is properly installed
- Check for PHP errors in the browser console or PHP error log

## Security Notes

- Files are validated by extension and MIME type
- Max file size: 5MB
- Use prepared statements for production (currently using real_escape_string)
- Consider adding file upload validation and sanitization
- Implement user authentication for production

## Customizing PDF Layout

Edit `backend/generate_pdf.php` to customize:
- Grid layout (columns per page)
- Image dimensions
- Font sizes
- Margins and spacing
- Background colors or watermarks

## Future Enhancements

- [ ] Add user authentication
- [ ] Implement image cropping/editing
- [ ] Add categories/tags for images
- [ ] Export images in bulk
- [ ] Add image search functionality
- [ ] Implement image versioning
