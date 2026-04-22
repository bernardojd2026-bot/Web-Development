<?php
include "db_connect.php";

/* =========================
   DELETE ITEM
========================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM items WHERE item_id = $id");
    header("Location: list_items.php");
    exit();
}

/* =========================
   UPDATE ITEM
========================= */
if (isset($_POST['item_id'])) {

    $stmt = $conn->prepare("
        UPDATE items
        SET item_name = ?, retail_value = ?, donor_id = ?
        WHERE item_id = ?
    ");

    $stmt->bind_param(
        "sdii",
        $_POST['item_name'],
        $_POST['retail_value'],
        $_POST['donor_id'],
        $_POST['item_id']
    );

    $stmt->execute();
}

/* =========================
   LOAD DATA
========================= */
$items = $conn->query("
    SELECT items.item_id,
           items.item_name,
           items.retail_value,
           items.donor_id,
           donors.name AS donor_name
    FROM items
    LEFT JOIN donors ON items.donor_id = donors.donor_id
    ORDER BY items.item_name
");

$donors = $conn->query("SELECT donor_id, name FROM donors ORDER BY name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Donated Items</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Manage Donated Items</h2>

<table>
<tr>
    <th>Item Name</th>
    <th>Retail Value</th>
    <th>Donor</th>
    <th>Actions</th>
</tr>

<?php while ($item = $items->fetch_assoc()) { ?>
<tr>
<form method="POST">

    <td>
        <input type="text" name="item_name"
               value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
    </td>

    <td>
        <input type="number" step="0.01" name="retail_value"
               value="<?php echo $item['retail_value']; ?>" required>
    </td>

    <td>
        <select name="donor_id" required>
            <option value="">-- Select Donor --</option>

            <?php
            // Reset donor result pointer safely
            $donors->data_seek(0);

            while ($d = $donors->fetch_assoc()) {
                $selected = ($d['donor_id'] == $item['donor_id']) ? "selected" : "";
                echo "<option value='{$d['donor_id']}' $selected>" .
                     htmlspecialchars($d['name']) .
                     "</option>";
            }
            ?>
        </select>

        <?php
        // If donor was deleted, warn but don't crash
        if (is_null($item['donor_name'])) {
            echo "<div style='color:red;font-size:12px;'>Donor missing</div>";
        }
        ?>
    </td>

    <td>
        <input type="hidden" name="item_id"
               value="<?php echo $item['item_id']; ?>">

        <button class="btn" type="submit">Save</button>

        <a class="btn danger"
           href="?delete=<?php echo $item['item_id']; ?>"
           onclick="return confirm('Delete this item?');">
           Delete
        </a>
    </td>

</form>
</tr>
<?php } ?>

</table>
</div>

</body>
</html>
