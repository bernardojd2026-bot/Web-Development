<?php include "db_connect.php"; ?>

<h2>Tax Receipt Status</h2>

<h3>Receipts NOT Sent</h3>

<?php
$result = $conn->query("SELECT * FROM donors WHERE tax_receipt_sent = 0");

while ($row = $result->fetch_assoc()) {
    echo "
    {$row['name']} - {$row['business']}
    <a href='generate_tax_receipt.php?donor_id={$row['donor_id']}'>Generate Receipt</a>
    <br>
    ";
}
?>

<hr>

<h3>Receipts Sent</h3>

<?php
$result = $conn->query("SELECT * FROM donors WHERE tax_receipt_sent = 1");

while ($row = $result->fetch_assoc()) {
    echo "
    {$row['name']} - {$row['business']} (Sent on {$row['tax_receipt_date']})
    <br>
    ";
}
?>
