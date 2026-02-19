<?php
include "db_connect.php";

$lots = $conn->query("SELECT lot_id, lot_name FROM lots ORDER BY lot_id");
$bidders = $conn->query("SELECT bidder_id, bidder_number FROM bidders ORDER BY bidder_number");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Winning Bids</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Record Winning Bids</h2>

<form method="POST">

<label>Auction Lot</label>
<select name="lot_id" required>
    <option value="">-- Select Lot --</option>
    <?php while ($l = $lots->fetch_assoc()) { ?>
        <option value="<?php echo $l['lot_id']; ?>">
            #<?php echo $l['lot_id']; ?> - <?php echo htmlspecialchars($l['lot_name']); ?>
        </option>
    <?php } ?>
</select>

<label>Winning Bidder</label>
<select name="bidder_id" required>
    <option value="">-- Select Bidder --</option>
    <?php while ($b = $bidders->fetch_assoc()) { ?>
        <option value="<?php echo $b['bidder_id']; ?>">
            Bidder #<?php echo $b['bidder_number']; ?>
        </option>
    <?php } ?>
</select>

<label>Winning Amount ($)</label>
<input type="number" step="0.01" name="amount" required>

<button type="submit">Record Winner</button>
</form>

<?php
if ($_POST) {

    $stmt = $conn->prepare("
        INSERT INTO winning_bids (lot_id, bidder_id, amount)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "iid",
        $_POST['lot_id'],
        $_POST['bidder_id'],
        $_POST['amount']
    );

    $stmt->execute();

    echo "<p style='color:green;'>Winning bid successfully recorded.</p>";
}
?>

</div>
</body>
</html>
