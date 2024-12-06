<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <form method="POST" action="users.php">
        <h2>Registration</h2>
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="select">Please select</option>
            <option value="Student">Student</option>
            <option value="Lecturer">Lecturer</option>
        </select>

        <input type="submit" name="submit" value="Register">

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</body>
</html>
