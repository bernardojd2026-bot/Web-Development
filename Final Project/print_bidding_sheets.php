<?php include "db_connect.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Printable Bidding Sheets</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container center">
<button onclick="window.print()">Print All Sheets</button>
</div>

<?php
$result = $conn->query("
    SELECT lots.*, categories.category_name
    FROM lots
    JOIN categories ON lots.category_id = categories.category_id
");

while ($lot = $result->fetch_assoc()) {
?>

<div class="container" style="page-break-after:always;">
<h2>Lot #<?php echo $lot['lot_id']; ?> - <?php echo $lot['lot_name']; ?></h2>
<p>Category: <?php echo $lot['category_name']; ?></p>

<table>
<tr><th>Bidder #</th><th>Bid Amount</th></tr>

<?php for ($i = 0; $i < 12; $i++) { ?>
<tr><td height="30"></td><td></td></tr>
<?php } ?>

</table>
</div>

<?php } ?>

</body>
</html>
