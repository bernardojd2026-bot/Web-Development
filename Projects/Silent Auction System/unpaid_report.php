<?php include "db_connect.php"; ?>

<h2>Unpaid Winners</h2>

<?php
$res = $conn->query(
    "SELECT bidders.name, bidders.email, winning_bids.amount
     FROM winning_bids
     JOIN bidders ON winning_bids.bidder_id = bidders.bidder_id
     WHERE bidders.paid = 0"
);

while ($row = $res->fetch_assoc()) {
    echo "{$row['name']} - {$row['email']} - ${row['amount']}<br>";
}
?>
