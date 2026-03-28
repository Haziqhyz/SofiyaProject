<?php
/**
 * Database Setup Script
 * Run this script once to create the database and tables
 * Access via: http://localhost/sofiya-adminlte/setup.php
 */

// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sofiya_db";

// Create connection (without database)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die('<div style="color: red; font-family: Arial; margin: 20px;">Connection failed: ' . $conn->connect_error . '</div>');
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

if ($conn->query($sql) === TRUE) {
    $message = '<div style="color: green; font-family: Arial; margin: 20px;">✓ Database created successfully</div>';
} else {
    $message = '<div style="color: red; font-family: Arial; margin: 20px;">Error creating database: ' . $conn->error . '</div>';
}

$conn->close();

// Connect to the new database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('<div style="color: red; font-family: Arial; margin: 20px;">Connection to database failed: ' . $conn->connect_error . '</div>');
}

// Create images table
$sql = "CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image_date DATE NOT NULL,
    image_filename VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at)
)";

if ($conn->query($sql) === TRUE) {
    $message .= '<div style="color: green; font-family: Arial; margin: 20px;">✓ Table created successfully</div>';
} else {
    $message .= '<div style="color: red; font-family: Arial; margin: 20px;">Error creating table: ' . $conn->error . '</div>';
}

// Create uploads directory
if (!is_dir('backend/uploads')) {
    if (mkdir('backend/uploads', 0755, true)) {
        $message .= '<div style="color: green; font-family: Arial; margin: 20px;">✓ Uploads directory created</div>';
    } else {
        $message .= '<div style="color: orange; font-family: Arial; margin: 20px;">⚠ Could not create uploads directory (may already exist)</div>';
    }
} else {
    $message .= '<div style="color: green; font-family: Arial; margin: 20px;">✓ Uploads directory exists</div>';
}

$conn->close();

// Display result
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗄️ Database Setup</h1>
        
        <?php
        // Parse and display messages with proper styling
        $lines = explode('</div>', $message);
        foreach ($lines as $line) {
            if (strpos($line, '<div') !== false) {
                if (strpos($line, 'color: green') !== false) {
                    echo '<div class="message success">' . strip_tags($line) . '</div>';
                } elseif (strpos($line, 'color: red') !== false) {
                    echo '<div class="message error">' . strip_tags($line) . '</div>';
                } elseif (strpos($line, 'color: orange') !== false) {
                    echo '<div class="message warning">' . strip_tags($line) . '</div>';
                }
            }
        }
        ?>
        
        <a href="input.php" class="button">Go to Image Manager</a>
    </div>
</body>
</html>
