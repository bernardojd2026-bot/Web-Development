<?php include "db_connect.php"; ?>

<h2>Undelivered Lots</h2>

<?php
$res = $conn->query(
    "SELECT lots.lot_name
     FROM winning_bids
     JOIN lots ON winning_bids.lot_id = lots.lot_id
     WHERE winning_bids.delivered = 0"
);

while ($row = $res->fetch_assoc()) {
    echo $row['lot_name'] . "<br>";
}
?>
