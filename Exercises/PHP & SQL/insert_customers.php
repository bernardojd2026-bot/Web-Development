<?php
$servername = "exampleserver";
$username = "exampleuser";
$password = "examplepass";
$dbname = "exampledb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and escape inputs
$FirstName = htmlspecialchars(trim($_POST['FirstName']));
$LastName = htmlspecialchars(trim($_POST['LastName']));
$Address1 = htmlspecialchars(trim($_POST['Address1']));
$City = htmlspecialchars(trim($_POST['City']));
$State = htmlspecialchars(trim($_POST['State']));
$Zip = htmlspecialchars(trim($_POST['Zip']));

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO Customers (FirstName, LastName, Address1, City, State, Zip)
                        VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $FirstName, $LastName, $Address1, $City, $State, $Zip);

if ($stmt->execute()) {
    echo "New customer added successfully.<br><a href='list_customers.php'>View Customers</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
