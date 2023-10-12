<?php
// Enable CORS headers
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Connect to the database
$db = new PDO('pgsql:host=localhost;dbname=roundcubemail;user=postgres;password=admin');

// Set PDO to throw exceptions on errors
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['matricule'])) {
    $matricule = $_POST['matricule'];

    // Query the database to get emails for the specified matricule
    $query = "SELECT email FROM eole_personnel WHERE matricule = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$matricule]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($results);
}
?>
