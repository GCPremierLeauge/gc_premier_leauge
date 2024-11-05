<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Execute the SQL query
$sql = "SELECT playerId, playerName FROM playerdetails";
$result = $conn->query($sql);

// Create the associative array
$players = array();
while ($row = mysqli_fetch_assoc($result)) {
  $players[$row["playerId"]] = $row["playerName"];
}

// Close the database connection
$conn->close();
// echo $players["13G301"];
// Test the associative array
// print_r($players);

?>
