<?php
include "db_connect.php";
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Auction Lot</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Add Auction Lot</h2>

<form method="POST" enctype="multipart/form-data">

<label>Lot Name</label>
<input name="lot_name" required>

<label>Description</label>
<textarea name="description" required></textarea>

<label>Category</label>
<select name="category_id" required>
    <option value="">-- Select Category --</option>
    <?php while ($cat = $categories->fetch_assoc()) { ?>
        <option value="<?php echo $cat['category_id']; ?>">
            <?php echo $cat['category_name']; ?>
        </option>
    <?php } ?>
</select>

<label>Starting Bid</label>
<input name="starting_bid" type="number" step="0.01" required>

<label>Bid Increment</label>
<input name="bid_increment" type="number" step="0.01" required>

<label>Photo</label>
<input type="file" name="photo" required>

<button type="submit">Add Lot</button>
</form>

<?php
if ($_POST) {
    if (!file_exists("uploads")) mkdir("uploads", 0777, true);

    $file = "uploads/" . time() . "_" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $file);

    $stmt = $conn->prepare("
        INSERT INTO lots (lot_name, description, category_id, photo_path, starting_bid, bid_increment)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssissd",
        $_POST['lot_name'],
        $_POST['description'],
        $_POST['category_id'],
        $file,
        $_POST['starting_bid'],
        $_POST['bid_increment']
    );

    $stmt->execute();
    echo "<p style='color:green;'>Auction lot added successfully.</p>";
}
?>

</div>
</body>
</html>
