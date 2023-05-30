<?php
// Start a session
session_start();

// Establish a database connection (example using mysqli)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_shoping";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's entered email and password
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute a database query (using prepared statements to prevent SQL injection)
$stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

// Check if the query returned a row
if ($result->num_rows > 0) {
    // User login successful
    // Store the user's email in a session variable (you can store other relevant information as well)
    $_SESSION['email'] = $email;

    // Redirect the user to the home page or any other desired page
    header("Location: home.php");
    exit();
} else {
    // Invalid login credentials
    // Display an error message or redirect to a login failed page
    header("Location: login_failed.php");
    exit();
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
