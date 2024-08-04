<?php
 
require 'lib/utils.php';
include 'partials/top.php'; 

$commentCode = $_GET['code'] ?? '';


echo '<h2>Commenting</h2>';


consoleLog($_POST, 'POST Data');

//Get form data
$password  = $_POST['Password'];


// Connect to database
$db = connectToDB();

// Set up a query to get all company info
$query = 'DELETE FROM Comments WHERE code=? AND password=?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute( [ $commentCode] );
    $item = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error adding data to the database');
}

echo '<p>Success<p>';

header('location: index.php');

include 'partials/bottom.php'; 

?>