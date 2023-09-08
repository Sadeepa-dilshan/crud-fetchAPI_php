<?php // Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "api";

// Create a database connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check for database connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>