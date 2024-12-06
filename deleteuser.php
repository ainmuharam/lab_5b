<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['matric'])) {
    $matric = $conn->real_escape_string($_GET['matric']);

    // Delete user
    $sql = "DELETE FROM users WHERE matric = '$matric'";
    if ($conn->query($sql)) {
        header("Location: displayuser.php");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>
