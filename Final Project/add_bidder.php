<?php include "db_connect.php"; ?>

<form method="POST">
Bidder Number: <input name="bidder_number"><br>
Name: <input name="name"><br>
Address: <input name="address"><br>
Cell: <input name="cell"><br>
Home: <input name="home"><br>
Email: <input name="email"><br>
<button>Register Bidder</button>
</form>

<?php
if ($_POST) {
    $stmt = $conn->prepare(
        "INSERT INTO bidders
         (bidder_number,name,address,cell,home,email)
         VALUES (?,?,?,?,?,?)"
    );
    $stmt->bind_param(
        "isssss",
        $_POST['bidder_number'],
        $_POST['name'],
        $_POST['address'],
        $_POST['cell'],
        $_POST['home'],
        $_POST['email']
    );
    $stmt->execute();
    echo "Bidder registered.";
}
?>
