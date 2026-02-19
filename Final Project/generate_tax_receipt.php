<?php
include "db_connect.php";
$donor_id = $_GET['donor_id'];
$donor = $conn->query("SELECT * FROM donors WHERE donor_id = $donor_id")->fetch_assoc();
$items = $conn->query("SELECT * FROM items WHERE donor_id = $donor_id");
$total = 0;
$date = date("F d, Y");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tax Receipt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<p><?php echo $date; ?></p>
<p>Dear <?php echo $donor['name']; ?>:</p>

<p>
Thank you for your support of W. H. Taylor’s PTA. Because of your generous donation, our PTA was able to help fund many important services for our school, as well as Taylor Families.<br><br>

<li>Our PTA helped fund the Backpack Program, through the Food Bank of Southeastern Virginia and Eastern Shore. This program enables the 30 identified students at our school that are at risk for hunger to go home each Friday with enough food to last their family through the weekend.
</li><br><br>
<li>Class field trips are open to all students, whether or not their family has the funds to pay the field trip fees. When the child’s family is unable to pay, W. H. Taylor PTA fills in the gap so every child can participate.
</li><br><br>
<li>Our PTA supports the teachers and school in a myriad of other ways as well. This would have been impossible without the support of our many donors
</li><br><br>

We acknowledge the receipt of your donation that you generously contributed to the W. H. Taylor PTA.
<br><br>
</p>

<p>Donor: <?php echo $donor['name']; ?>:</p>

<table>
<tr><th>Description</th><th>Retail Value</th></tr>

<?php while ($row = $items->fetch_assoc()) {
    $total += $row['retail_value'];
?>
<tr>
    <td><?php echo $row['item_name']; ?></td>
    <td>$<?php echo number_format($row['retail_value'], 2); ?></td>
</tr>
<?php } ?>

<tr>
    <th>Total</th>
    <th>$<?php echo number_format($total, 2); ?></th>
</tr>
</table>

<p>
W.H. Taylor Elementary School PTA is a non-profit 501 (c)(3) organization. Your gift(s) are tax deductable to the extent allowed by the law. W.H. Taylor PTA Tax ID is #54-1190250<br><br>

No goods or services were received in return for this donation.<br><br>

Thank you again for your generous support.<br><br>

Sincerely,<br><br>


Tamara Haines<br>
W.H. Taylor PTA Silent Auction Chairperson<br>
XXX-XXX-XXXX<br>
HYPERLINK "mailto:xxxxxxxx@yahoo.com"xxxxxxxx@yahoo.com<br>
</p>

<form method="post" action="mark_tax_sent.php?donor_id=<?php echo $donor_id; ?>">
    <button type="submit">Mark Receipt as Sent</button>
    <button type="button" onclick="window.print()">Print Receipt</button>
</form>

</div>
</body>
</html>
