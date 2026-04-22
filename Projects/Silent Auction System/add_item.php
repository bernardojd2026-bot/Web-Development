<?php
include "db_connect.php";
$donors = $conn->query("SELECT donor_id, name FROM donors ORDER BY name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Donated Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Add Donated Item</h2>

<form method="POST">

<label>Item Name</label>
<input name="item_name" required>

<label>Retail Value</label>
<input type="number" name="retail_value" step="0.01" required>

<label>Donor</label>
<select name="donor_id" required>
    <option value="">-- Select Donor --</option>
    <?php while ($d = $donors->fetch_assoc()) { ?>
        <option value="<?php echo $d['donor_id']; ?>">
            <?php echo htmlspecialchars($d['name']); ?>
        </option>
    <?php } ?>
</select>

<button type="submit">Save Item</button>
</form>

<?php
if ($_POST) {

    $stmt = $conn->prepare("
        INSERT INTO items (item_name, retail_value, donor_id)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "sdi",
        $_POST['item_name'],
        $_POST['retail_value'],
        $_POST['donor_id']
    );

    $stmt->execute();

    echo "<p style='color:green;'>Item successfully saved.</p>";
}
?>

</div>
</body>
</html>
