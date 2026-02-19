<?php
include "db_connect.php";

$donor_id = $_GET['donor_id'];

$conn->query("
    UPDATE donors 
    SET tax_receipt_sent = 1,
        tax_receipt_date = CURDATE()
    WHERE donor_id = $donor_id
");

header("Location: list_tax_receipts.php");
?>
