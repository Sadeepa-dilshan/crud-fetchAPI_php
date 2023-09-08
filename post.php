<?php
// Enable CORS (Cross-Origin Resource Sharing) to allow requests from different origins
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'dbcon.php';

// Check the request method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Validate and sanitize the data (adjust this according to your requirements)
    $name = $mysqli->real_escape_string($data->name);
    $price = $mysqli->real_escape_string($data->price);

    // Insert data into the database
    $sql = "INSERT INTO items (name, price) VALUES ('$name', '$price')";

    if ($mysqli->query($sql) === true) {
        echo json_encode(["message" => "Data inserted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $mysqli->error]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"]);
}

$mysqli->close();
?>
