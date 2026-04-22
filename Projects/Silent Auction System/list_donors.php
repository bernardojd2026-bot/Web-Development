<?php
include "db_connect.php";

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Prevent delete if donor has items
    $check = $conn->query("SELECT COUNT(*) AS cnt FROM items WHERE donor_id=$id")->fetch_assoc();
    if ($check['cnt'] == 0) {
        $conn->query("DELETE FROM donors WHERE donor_id=$id");
        header("Location: list_donors.php");
        exit();
    } else {
        $error = "Cannot delete donor: Items still assigned.";
    }
}

if ($_POST) {
    $stmt = $conn->prepare("UPDATE donors SET name=?, email=? WHERE donor_id=?");
    $stmt->bind_param("ssi", $_POST['name'], $_POST['email'], $_POST['donor_id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head><title>Manage Donors</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">

<h2>Manage Donors</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<table>
<tr><th>Name</th><th>Email</th><th>Actions</th></tr>

<?php
$res = $conn->query("SELECT * FROM donors ORDER BY name");
while ($d = $res->fetch_assoc()) {
?>
<tr>
<form method="POST">
<td>
    <input name="name" value="<?php echo htmlspecialchars($d['name']); ?>">
</td>
<td>
    <input name="email" value="<?php echo htmlspecialchars($d['email']); ?>">
</td>
<td>
    <input type="hidden" name="donor_id" value="<?php echo $d['donor_id']; ?>">
    <button class="btn">Save</button>
    <a class="btn danger" href="?delete=<?php echo $d['donor_id']; ?>" onclick="return confirm('Delete donor?')">Delete</a>
</td>
</form>
</tr>
<?php } ?>

</table>
</div>
</body>
</html>
