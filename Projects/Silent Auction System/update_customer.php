<?php
$servername = "exampleserver";
$username = "exampleuser";
$password = "examplepass";
$dbname = "exampledb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$UserID = intval($_POST['UserID']);
$FirstName = htmlspecialchars(trim($_POST['FirstName']));
$LastName = htmlspecialchars(trim($_POST['LastName']));
$Address1 = htmlspecialchars(trim($_POST['Address1']));
$City = htmlspecialchars(trim($_POST['City']));
$State = htmlspecialchars(trim($_POST['State']));
$Zip = htmlspecialchars(trim($_POST['Zip']));

$stmt = $conn->prepare("UPDATE Customers 
                        SET FirstName=?, LastName=?, Address1=?, City=?, State=?, Zip=? 
                        WHERE UserID=?");
$stmt->bind_param("ssssssi", $FirstName, $LastName, $Address1, $City, $State, $Zip, $UserID);

if ($stmt->execute()) {
    echo "Customer updated successfully.<br><a href='list_customers.php'>Back to list</a>";
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
