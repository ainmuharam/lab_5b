<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include 'db.php'; 

$error = '';
$success = '';
$original_matric = ''; 
$name = '';
$role = '';

if (isset($_GET['matric'])) {
    $original_matric = $conn->real_escape_string($_GET['matric']);

    $sql = "SELECT * FROM users WHERE matric = '$original_matric'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $role = $user['role'];
    } else {
        $error = "User not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $original_matric = $conn->real_escape_string($_POST['original_matric']);
    $new_matric = $conn->real_escape_string($_POST['new_matric']);
    $name = $conn->real_escape_string($_POST['name']);
    $role = $conn->real_escape_string($_POST['role']);

    if (!empty($new_matric) && !empty($name) && $role !== 'select') {
        $sql = "UPDATE users SET matric = '$new_matric', name = '$name', role = '$role' WHERE matric = '$original_matric'";

        if ($conn->query($sql)) {
            $success = "User updated successfully!";
            header("Location: displayuser.php"); 
            exit;
        } else {
            $error = "Error updating user: " . $conn->error;
        }
    } else {
        $error = "All fields are required, and access level must be valid.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Update User</h2>
            <a href="logout.php" class="logout-button">Logout</a> <!-- Logout button -->
        </div>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="updateuser.php">

            <input type="hidden" name="original_matric" value="<?php echo htmlspecialchars($original_matric); ?>">

            <label for="new_matric">Matric:</label>
            <input type="text" id="new_matric" name="new_matric" value="<?php echo htmlspecialchars($original_matric); ?>" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="role">Access Level:</label>
            <select id="role" name="role" required>
                <option value="select">Please select</option>
                <option value="student" <?php echo ($role === 'student') ? 'selected' : ''; ?>>Student</option>
                <option value="lecturer" <?php echo ($role === 'lecturer') ? 'selected' : ''; ?>>Lecturer</option>
            </select>

            <div class="buttons">
            <input type="submit" name="submit" value="Update">
            <button type="button" onclick="window.location.href='displayuser.php';">Cancel</button>            </div>
        </form>
    </div>
</body>
</html>
