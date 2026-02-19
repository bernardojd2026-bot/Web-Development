<?php
$servername = "cis3870-2504.mysql.database.azure.com";
$username = "bernardojd_fc";
$password = "0cc497ad5c63020bf8d145f8";
$dbname = "bernardojd_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$UserID = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM Customers WHERE UserID = ?");
$stmt->bind_param("i", $UserID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
</head>
<body>
    <h2>Edit Customer</h2>
    <form action="update_customer.php" method="POST">
        <input type="hidden" name="UserID" value="<?= htmlspecialchars($row['UserID']) ?>">
        First Name: <input type="text" name="FirstName" value="<?= htmlspecialchars($row['FirstName']) ?>" required><br>
        Last Name: <input type="text" name="LastName" value="<?= htmlspecialchars($row['LastName']) ?>" required><br>
        Address: <input type="text" name="Address1" value="<?= htmlspecialchars($row['Address1']) ?>"><br>
        City: <input type="text" name="City" value="<?= htmlspecialchars($row['City']) ?>"><br>
        State: <input type="text" name="State" maxlength="2" value="<?= htmlspecialchars($row['State']) ?>"><br>
        Zip: <input type="text" name="Zip" maxlength="10" value="<?= htmlspecialchars($row['Zip']) ?>"><br>
        <input type="submit" value="Update">
    </form>
    <br>
    <a href="list_customers.php">Back to Customer List</a>
</body>
</html>
<?php
} else {
    echo "Customer not found.<br><a href='list_customers.php'>Back to list</a>";
}
$stmt->close();
$conn->close();
?>
