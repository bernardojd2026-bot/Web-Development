<?php
include "db_connect.php";

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $check = $conn->query("SELECT COUNT(*) AS cnt FROM winning_bids WHERE bidder_id=$id")->fetch_assoc();
    if ($check['cnt'] == 0) {
        $conn->query("DELETE FROM bidders WHERE bidder_id=$id");
        header("Location: list_bidders.php");
        exit();
    } else {
        $error = "Cannot delete bidder: Winning bids exist.";
    }
}

if ($_POST) {
    $stmt = $conn->prepare("UPDATE bidders SET name=?, email=?, paid=? WHERE bidder_id=?");
    $stmt->bind_param("ssii", $_POST['name'], $_POST['email'], $_POST['paid'], $_POST['bidder_id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head><title>Manage Bidders</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">

<h2>Manage Bidders</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<table>
<tr><th>Name</th><th>Email</th><th>Paid</th><th>Actions</th></tr>

<?php
$res = $conn->query("SELECT * FROM bidders ORDER BY bidder_number");
while ($b = $res->fetch_assoc()) {
?>
<tr>
<form method="POST">
<td><input name="name" value="<?php echo htmlspecialchars($b['name']); ?>"></td>
<td><input name="email" value="<?php echo htmlspecialchars($b['email']); ?>"></td>
<td>
<select name="paid">
    <option value="0" <?php if (!$b['paid']) echo "selected"; ?>>No</option>
    <option value="1" <?php if ($b['paid']) echo "selected"; ?>>Yes</option>
</select>
</td>
<td>
<input type="hidden" name="bidder_id" value="<?php echo $b['bidder_id']; ?>">
<button class="btn">Save</button>
<a class="btn danger" href="?delete=<?php echo $b['bidder_id']; ?>" onclick="return confirm('Delete bidder?')">Delete</a>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
