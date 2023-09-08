<?php
// Enable CORS (Cross-Origin Resource Sharing) to allow requests from different origins
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'dbcon.php';

// SQL query to retrieve all items from the "items" table
$sql = "SELECT id, name, price FROM items";
$result = $mysqli->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    // Initialize an array to store the results
    $items = array();

    // Fetch the data and add it to the array
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    // Close the database connection
    $mysqli->close();

    // Respond with the data as JSON
    echo json_encode($items);
} else {
    // If there are no items in the database, respond with an empty JSON array
    echo json_encode(array());
}



?>
