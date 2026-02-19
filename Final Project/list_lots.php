<?php
include "db_connect.php";

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $check = $conn->query("SELECT COUNT(*) AS cnt FROM winning_bids WHERE lot_id=$id")->fetch_assoc();
    if ($check['cnt'] == 0) {
        $conn->query("DELETE FROM lots WHERE lot_id=$id");
        header("Location: list_lots.php");
        exit();
    } else {
        $error = "Cannot delete lot: Winning bids already recorded.";
    }
}

if ($_POST) {
    $stmt = $conn->prepare("
        UPDATE lots 
        SET lot_name=?, starting_bid=?, bid_increment=? 
        WHERE lot_id=?
    ");
    $stmt->bind_param("sdii",
        $_POST['lot_name'],
        $_POST['starting_bid'],
        $_POST['bid_increment'],
        $_POST['lot_id']
    );
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head><title>Manage Lots</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">

<h2>Manage Auction Lots</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<table>
<tr><th>Lot</th><th>Start</th><th>Increment</th><th>Actions</th></tr>

<?php
$res = $conn->query("SELECT * FROM lots");
while ($l = $res->fetch_assoc()) {
?>
<tr>
<form method="POST">
<td><input name="lot_name" value="<?php echo htmlspecialchars($l['lot_name']); ?>"></td>
<td><input name="starting_bid" value="<?php echo $l['starting_bid']; ?>"></td>
<td><input name="bid_increment" value="<?php echo $l['bid_increment']; ?>"></td>
<td>
<input type="hidden" name="lot_id" value="<?php echo $l['lot_id']; ?>">
<button class="btn">Save</button>
<a class="btn danger" href="?delete=<?php echo $l['lot_id']; ?>" onclick="return confirm('Delete lot?')">Delete</a>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
