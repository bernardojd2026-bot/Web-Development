<?php include "db_connect.php"; ?>

<form method="POST">
Category Name: <input name="category_name">
<button>Add Category</button>
</form>

<?php
if ($_POST) {
    $stmt = $conn->prepare(
        "INSERT INTO categories (category_name) VALUES (?)"
    );
    $stmt->bind_param("s", $_POST['category_name']);
    $stmt->execute();
    echo "Category added.";
}
?>
