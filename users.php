<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user inputs
    $matric = $conn->real_escape_string($_POST['matric']);
    $name = $conn->real_escape_string($_POST['name']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT); // Hash password
    $role = $conn->real_escape_string($_POST['role']);

    if ($role == "select") {
        echo "Please select a valid role.";
    } else {
        // Prepare SQL query
        $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
