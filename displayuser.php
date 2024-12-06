<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

    header("Location: login.php");
    exit;
}

include 'db.php';

$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>User List</h2>
            <a href="logout.php" class="logout-button">Logout</a> 
        </div>
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Access Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['matric']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['role']}</td>
                                <td class='action-buttons'>
                                    <a href='updateuser.php?matric={$row['matric']}'>Update</a>
                                    <a href='deleteuser.php?matric={$row['matric']}' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php

$conn->close();
?>
