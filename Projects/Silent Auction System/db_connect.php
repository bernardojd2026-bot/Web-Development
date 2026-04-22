<?php

$host = "examplehost";
$user = "exampleuser";
$pass = "examplepass";
$db   = "exampledb";

$conn = new mysqli($host, $user, $pass, $db);

// ==============================
// CONNECTION ERROR HANDLING
// ==============================

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Force UTF-8 Encoding
$conn->set_charset("utf8mb4");

// ==============================
// AUTO-FIX FOR TAX RECEIPT COLUMN
// (Runs only once if missing)
// ==============================

$check = $conn->query("SHOW COLUMNS FROM donors LIKE 'tax_receipt_sent'");

if ($check && $check->num_rows == 0) {
    $conn->query("
        ALTER TABLE donors 
        ADD tax_receipt_sent TINYINT(1) DEFAULT 0
    ");
}

?>
