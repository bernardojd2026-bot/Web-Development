<?php
session_start(); 

$servername = "exampleserver";
$username = "exampleuser";
$password = "examplepass";
$dbname = "exampledb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$selectedCustomer = null;
$message = "";

// Handle undo
if (isset($_POST['undo']) && isset($_SESSION['previousCustomer'])) {
    $prev = $_SESSION['previousCustomer'];
    $stmt = $conn->prepare("UPDATE Customers SET FirstName=?, LastName=?, Address1=?, City=?, State=?, Zip=? WHERE UserID=?");
    $stmt->bind_param("ssssssi", $prev['FirstName'], $prev['LastName'], $prev['Address1'], $prev['City'], $prev['State'], $prev['Zip'], $prev['UserID']);
    $stmt->execute();
    $message = "<p style='color:blue;'>Changes undone!</p>";
    unset($_SESSION['previousCustomer']);
    $stmt->close();
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UserID']) && !isset($_POST['undo'])) {
    $id = intval($_POST['UserID']);
    $firstName = htmlspecialchars(trim($_POST["FirstName"]));
    $lastName = htmlspecialchars(trim($_POST["LastName"]));
    $address1 = htmlspecialchars(trim($_POST["Address1"]));
    $city = htmlspecialchars(trim($_POST["City"]));
    $state = htmlspecialchars(trim($_POST["State"]));
    $zip = htmlspecialchars(trim($_POST["Zip"]));

    // Store previous values for undo
    $stmt = $conn->prepare("SELECT * FROM Customers WHERE UserID=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION['previousCustomer'] = $result->fetch_assoc();
    $stmt->close();

    // Update customer
    $stmt = $conn->prepare("UPDATE Customers SET FirstName=?, LastName=?, Address1=?, City=?, State=?, Zip=? WHERE UserID=?");
    $stmt->bind_param("ssssssi", $firstName, $lastName, $address1, $city, $state, $zip, $id);
    if ($stmt->execute()) {
        $message = "<p style='color:green;'>Customer updated successfully!</p>";
    } else {
        $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Handle selection
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM Customers WHERE UserID=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $selectedCustomer = $result->fetch_assoc();
    $stmt->close();
}

// Fetch all customers for selection
$result = $conn->query("SELECT UserID, FirstName, LastName FROM Customers ORDER BY LastName, FirstName");
?>

<h2>Modify Customer</h2>
<?php echo $message; ?>

<h3>Select Customer:</h3>
<form method="get" action="">
    <select name="edit" onchange="this.form.submit()">
        <option value="">-- Select Customer --</option>
        <?php
        while ($row = $result->fetch_assoc()) {
            $selected = ($selectedCustomer && $selectedCustomer['UserID'] == $row['UserID']) ? "selected" : "";
            echo "<option value='" . htmlspecialchars($row['UserID']) . "' $selected>" .
                 htmlspecialchars($row['FirstName'] . " " . $row['LastName']) . "</option>";
        }
        ?>
    </select>
</form>

<?php if ($selectedCustomer): ?>
<h3>Edit Customer Details:</h3>
<form method="post" action="">
    <input type="hidden" name="UserID" value="<?php echo htmlspecialchars($selectedCustomer['UserID']); ?>">
    <label>First Name:</label><br>
    <input type="text" name="FirstName" value="<?php echo htmlspecialchars($selectedCustomer['FirstName']); ?>" required><br>
    <label>Last Name:</label><br>
    <input type="text" name="LastName" value="<?php echo htmlspecialchars($selectedCustomer['LastName']); ?>" required><br>
    <label>Address:</label><br>
    <input type="text" name="Address1" value="<?php echo htmlspecialchars($selectedCustomer['Address1']); ?>"><br>
    <label>City:</label><br>
    <input type="text" name="City" value="<?php echo htmlspecialchars($selectedCustomer['City']); ?>"><br>
    <label>State:</label><br>
    <input type="text" name="State" value="<?php echo htmlspecialchars($selectedCustomer['State']); ?>"><br>
    <label>Zip:</label><br>
    <input type="text" name="Zip" value="<?php echo htmlspecialchars($selectedCustomer['Zip']); ?>"><br><br>
    <input type="submit" value="Update Customer">
    <?php if (isset($_SESSION['previousCustomer'])): ?>
        <button type="submit" name="undo">Undo Last Change</button>
    <?php endif; ?>
</form>
<?php endif; ?>
