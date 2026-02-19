<?php
// Database connection
$servername = "cis3870-2504.mysql.database.azure.com";
$username = "bernardojd_fc";
$password = "0cc497ad5c63020bf8d145f8";
$dbname = "bernardojd_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS Customers (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Address1 VARCHAR(100),
    City VARCHAR(50),
    State CHAR(2),
    Zip VARCHAR(10)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'Customers' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
