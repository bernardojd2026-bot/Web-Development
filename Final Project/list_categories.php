<?php
include "db_connect.php";

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $check = $conn->query("SELECT COUNT(*) AS cnt FROM lots WHERE category_id=$id")->fetch_assoc();
    if ($check['cnt'] == 0) {
        $conn->query("DELETE FROM categories WHERE category_id=$id");
        header("Location: list_categories.php");
        exit();
    } else {
        $error = "Cannot delete category: Lots still assigned.";
    }
}

if ($_POST) {
    $stmt = $conn->prepare("UPDATE categories SET category_name=? WHERE category_id=?");
    $stmt->bind_param("si", $_POST['category_name'], $_POST['category_id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head><title>Manage Categories</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">

<h2>Manage Categories</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<table>
<tr><th>Category</th><th>Actions</th></tr>

<?php
$res = $conn->query("SELECT * FROM categories");
while ($c = $res->fetch_assoc()) {
?>
<tr>
<form method="POST">
<td>
<input name="category_name" value="<?php echo htmlspecialchars($c['category_name']); ?>">
</td>
<td>
<input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
<button class="btn">Save</button>
<a class="btn danger" href="?delete=<?php echo $c['category_id']; ?>" onclick="return confirm('Delete category?')">Delete</a>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
