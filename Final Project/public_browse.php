<?php
include "db_connect.php";

$search = isset($_GET['search']) ? $_GET['search'] : "";
$cat_filter = isset($_GET['category']) ? $_GET['category'] : "";

$sql = "
SELECT lots.*, categories.category_name
FROM lots
JOIN categories ON lots.category_id = categories.category_id
WHERE 1
";

if ($search != "") {
    $safe = $conn->real_escape_string($search);
    $sql .= " AND (lots.lot_name LIKE '%$safe%' OR lots.description LIKE '%$safe%')";
}

if ($cat_filter != "") {
    $sql .= " AND categories.category_id = $cat_filter";
}

$result = $conn->query($sql);
$categories = $conn->query("SELECT * FROM categories ORDER BY category_name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Silent Auction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1 style="text-align:center;">Silent Auction Items</h1>

<!-- SEARCH + FILTER -->
<form method="get" class="search-bar">
    <input type="text" name="search" placeholder="Search items..." value="<?php echo htmlspecialchars($search); ?>">

    <select name="category">
        <option value="">All Categories</option>
        <?php while ($cat = $categories->fetch_assoc()) { ?>
            <option value="<?php echo $cat['category_id']; ?>" <?php if ($cat_filter == $cat['category_id']) echo "selected"; ?>>
                <?php echo htmlspecialchars($cat['category_name']); ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Search</button>
</form>

<hr>

<!-- LOT GRID -->
<div class="lot-grid">

<?php
if ($result->num_rows == 0) {
    echo "<p style='text-align:center;'>No items found.</p>";
}

while ($lot = $result->fetch_assoc()) {
?>
    <div class="lot-card">
        <img src="<?php echo $lot['photo_path']; ?>" alt="Lot Image">

        <h3><?php echo htmlspecialchars($lot['lot_name']); ?></h3>

        <p class="category-tag"><?php echo htmlspecialchars($lot['category_name']); ?></p>

        <p><?php echo nl2br(htmlspecialchars($lot['description'])); ?></p>

        <p class="price">
            Starting Bid: $<?php echo number_format($lot['starting_bid'], 2); ?><br>
            Bid Increment: $<?php echo number_format($lot['bid_increment'], 2); ?>
        </p>

        <a class="btn" href="lot_details.php?lot_id=<?php echo $lot['lot_id']; ?>">View Details</a>
    </div>
<?php } ?>

</div>

</div>
</body>
</html>
