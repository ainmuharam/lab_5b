<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $conn->real_escape_string($_POST['matric']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to fetch user details
    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect to user list page
            header("Location: displayuser.php");
            exit;
        } else {
            $error = "Invalid Matric or Password. <a href='login.php'>Try again</a>";
        }
    } else {
        $error = "Invalid Matric or Password. <a href='login.php'>Try again</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="submit" value="Login">

        <p>Don't have an account? <a href="registerform.php">Register here</a>.</p>
    </form>
</body>
</html>
