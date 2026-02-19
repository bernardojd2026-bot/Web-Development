<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
</head>
<body>
    <h2>Add a New Customer</h2>
    <form action="insert_customers.php" method="POST">
        First Name: <input type="text" name="FirstName" required><br>
        Last Name: <input type="text" name="LastName" required><br>
        Address: <input type="text" name="Address1"><br>
        City: <input type="text" name="City"><br>
        State: <input type="text" name="State" maxlength="2"><br>
        Zip: <input type="text" name="Zip" maxlength="10"><br>
        <input type="submit" value="Add Customer">
    </form>
</body>
</html>
