<?php include "db_connect.php"; ?>

<form method="POST">
Name: <input name="name"><br>
Business: <input name="business"><br>
Address: <input name="address"><br>
Phone: <input name="phone"><br>
Email: <input name="email"><br>
<button type="submit">Add Donor</button>
</form>

<?php
if ($_POST) {
    $stmt = $conn->prepare(
        "INSERT INTO donors (name,business,address,phone,email) VALUES (?,?,?,?,?)"
    );
    $stmt->bind_param(
        "sssss",
        $_POST['name'],
        $_POST['business'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['email']
    );
    $stmt->execute();
    echo "Donor added.";
}
?>
