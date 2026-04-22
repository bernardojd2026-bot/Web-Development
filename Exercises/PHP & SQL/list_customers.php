<?php
$servername = "cis3870-2504.mysql.database.azure.com";
$username = "bernardojd_fc";
$password = "0cc497ad5c63020bf8d145f8";
$dbname = "bernardojd_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM Customers ORDER BY UserID ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
</head>
<body>
    <h2>Customer List</h2>
    <p>
        <a href="add_customers.php">Add New Customer</a> |
        <a href="index.php">Back to Homepage</a>
    </p>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>
                <tr>
                    <th>UserID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Actions</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $UserID = htmlspecialchars($row['UserID']);
            $FirstName = htmlspecialchars($row['FirstName']);
            $LastName = htmlspecialchars($row['LastName']);
            $Address1 = htmlspecialchars($row['Address1']);
            $City = htmlspecialchars($row['City']);
            $State = htmlspecialchars($row['State']);
            $Zip = htmlspecialchars($row['Zip']);

            echo "<tr>
                    <td>{$UserID}</td>
                    <td>{$FirstName} {$LastName}</td>
                    <td>{$Address1}</td>
                    <td>{$City}</td>
                    <td>{$State}</td>
                    <td>{$Zip}</td>
                    <td>
                        <a href='edit_customer.php?id={$UserID}'>Edit</a> |
                        <a href='delete_customer.php?id={$UserID}' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No customers found.";
    }

    $conn->close();
    ?>
</body>
</html>