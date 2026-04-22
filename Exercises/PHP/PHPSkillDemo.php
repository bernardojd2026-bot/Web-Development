<!DOCTYPE html>
<html>
<head>
    <title>PHP Exercises</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav a { margin: 10px; text-decoration: none; color: blue; }
        nav a:hover { text-decoration: underline; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<nav>
    <a href="?page=exercise1">Exercise 1</a> |
    <a href="?page=exercise2">Exercise 2</a> |
    <a href="?page=exercise3">Exercise 3</a> |
    <a href="?page=skilldemo">Skill Demo</a>
</nav>
<hr>

<?php
$page = $_GET['page'] ?? 'exercise1';

function safe($val) {
    return htmlspecialchars($val ?? '');
}

switch ($page) {
    case "exercise1":
        echo "<h2>Exercise 1 - Name Validation</h2>";
        $firstName = $lastName = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["exercise1"])) {
            $firstName = trim($_POST["firstName"]);
            $lastName  = trim($_POST["lastName"]);

            if (empty($firstName) || empty($lastName)) {
                $error = "Both first and last name must contain at least one character.";
            } else {
                echo "<p class='success'>Success! You entered: $firstName $lastName</p>";
            }
        }
        ?>
        <form method="post">
            First Name: <input type="text" name="firstName" value="<?= safe($firstName) ?>"><br><br>
            Last Name: <input type="text" name="lastName" value="<?= safe($lastName) ?>"><br><br>
            <input type="submit" name="exercise1" value="Submit">
        </form>
        <p class="error"><?= $error ?></p>
        <?php
        break;

    case "exercise2":
        echo "<h2>Exercise 2 - Email Validation</h2>";
        $email = $confirmEmail = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["exercise2"])) {
            $email = trim($_POST["email"]);
            $confirmEmail = trim($_POST["confirmEmail"]);

            if (empty($email) || empty($confirmEmail)) {
                $error = "Both email fields are required.";
            } elseif ($email !== $confirmEmail) {
                $error = "Email addresses do not match.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } else {
                echo "<p class='success'>Success! Email validated: $email</p>";
            }
        }
        ?>
        <form method="post">
            Email Address: <input type="text" name="email" value="<?= safe($email) ?>"><br><br>
            Confirm Email: <input type="text" name="confirmEmail" value="<?= safe($confirmEmail) ?>"><br><br>
            <input type="submit" name="exercise2" value="Submit">
        </form>
        <p class="error"><?= $error ?></p>
        <?php
        break;

    case "exercise3":
        echo "<h2>Exercise 3 - Password Validation</h2>";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["exercise3"])) {
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirmPassword"];

            if (strlen($password) < 8) {
                $error = "Password must be at least 8 characters long.";
            } elseif ($password !== $confirmPassword) {
                $error = "Passwords do not match.";
            } elseif (!preg_match("/[0-9]/", $password)) {
                $error = "Password must contain at least one number.";
            } elseif (!preg_match("/[A-Z]/", $password)) {
                $error = "Password must contain at least one uppercase letter.";
            } elseif (!preg_match("/[a-z]/", $password)) {
                $error = "Password must contain at least one lowercase letter.";
            } elseif (!preg_match("/[\W]/", $password)) {
                $error = "Password must contain at least one punctuation mark.";
            } else {
                echo "<p class='success'>Password is valid!</p>";
            }
        }
        ?>
        <form method="post">
            Create Password: <input type="password" name="password"><br><br>
            Confirm Password: <input type="password" name="confirmPassword"><br><br>
            <input type="submit" name="exercise3" value="Submit">
        </form>
        <p class="error"><?= $error ?></p>
        <?php
        break;

    case "skilldemo":
        echo "<h2>Skill Demonstration</h2>";
        $bannerID = $firstName = $lastName = $pictureURL = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["skilldemo"])) {
            $bannerID   = trim($_POST["bannerID"]);
            $firstName  = trim($_POST["firstName"]);
            $lastName   = trim($_POST["lastName"]);
            $pictureURL = trim($_POST["pictureURL"]);

            if (empty($bannerID) || empty($firstName) || empty($lastName) || empty($pictureURL)) {
                $error = "All fields are required.";
            } elseif (!preg_match("/^[0-9]{9}$/", $bannerID)) {
                $error = "BannerID must be a 9-digit number.";
            } elseif (strlen($firstName) > 15) {
                $error = "First name must be 15 characters or less.";
            } elseif ((strlen($firstName) + strlen($lastName)) > 30) {
                $error = "First + Last name together cannot exceed 30 characters.";
            } elseif (!filter_var($pictureURL, FILTER_VALIDATE_URL)) {
                $error = "Picture URL is not valid.";
            } else {
                echo "<p class='success'>Form submitted successfully!</p>";
                echo "<ul>
                        <li>BannerID: $bannerID</li>
                        <li>Name: $firstName $lastName</li>
                        <li>Picture URL: <a href='$pictureURL' target='_blank'>$pictureURL</a></li>
                      </ul>";
            }
        }
        ?>
        <form method="post">
            BannerID: <input type="text" name="bannerID" value="<?= safe($bannerID) ?>"><br><br>
            First Name: <input type="text" name="firstName" value="<?= safe($firstName) ?>"><br><br>
            Last Name: <input type="text" name="lastName" value="<?= safe($lastName) ?>"><br><br>
            Picture URL: <input type="text" name="pictureURL" value="<?= safe($pictureURL) ?>"><br><br>
            <input type="submit" name="skilldemo" value="Submit">
        </form>
        <p class="error"><?= $error ?></p>
        <?php
        break;
}
?>
</body>
</html>
