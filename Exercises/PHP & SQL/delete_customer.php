<?php
$servername = "cis3870-2504.mysql.database.azure.com";
$username = "bernardojd_fc";
$password = "0cc497ad5c63020bf8d145f8";
$dbname = "bernardojd_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$UserID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($UserID > 0) {
    $stmt = $conn->prepare("DELETE FROM Customers WHERE UserID = ?");
    $stmt->bind_param("i", $UserID);
    $stmt->execute();
    echo "Customer deleted successfully.<br><a href='list_customers.php'>Back to list</a>";
    $stmt->close();
} else {
    echo "Invalid customer ID.";
}
$conn->close();
?>
