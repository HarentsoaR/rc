<?php
// Enable CORS headers
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Include your database connection file
$db = new PDO('pgsql:host=localhost;dbname=roundcubemail;user=postgres;password=admin');

// Get the start and end dates from the request parameters
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Prepare the SQL query
$query = $db->prepare('SELECT * FROM email_historique WHERE DATE(date) BETWEEN :startDate AND :endDate');

// Bind the parameters to the query
$query->bindParam(':startDate', $startDate);
$query->bindParam(':endDate', $endDate);

// Execute the query
$query->execute();

// Fetch the data into an array
$data = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// Return the data as a JSON response
echo json_encode($data);
?>