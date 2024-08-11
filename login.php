<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["user"]) && !empty($_POST["password"])) {
        $connection = new mysqli("localhost", "root", "", "system");

        if ($connection->connect_errno) {
            die("Connection failed: " . $connection->connect_error);
        }

        $username = $_POST["user"];
        $password = $_POST["password"];
        $stmt = $connection->prepare("SELECT id, username, password FROM user_accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $dbUsername, $dbPassword);
            $stmt->fetch();
            if (password_verify($password, $dbPassword)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $dbUsername;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
        $connection->close();
    } else {
        $error = "Please fill out both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form action="login.php" method="POST">
        <div>
            <label for="user">Username:</label>
            <input type="text" name="user" id="user" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
</body>
</html>
