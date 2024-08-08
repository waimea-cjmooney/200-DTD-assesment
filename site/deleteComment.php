<?php
 
require 'lib/utils.php';
include 'partials/top.php'; 

$commentCode = $_GET['code'] ?? '';
$postId = $_GET['id'] ?? '';

echo $postId;
echo '<h2>Deleting</h2>';

consoleLog($commentCode, $postId, 'get');
consoleLog($_POST, 'POST Data');

//Get form data
$password  = $_POST['Password'];


// Connect to database
$db = connectToDB();

// Set up a query to get all company info
$query = 'DELETE FROM Comments WHERE code=? AND cPass=?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute( [ $commentCode, $password ] );
    $item = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error adding data to the database');
}

echo '<p>Success<p>';


header('location: viewPost.php?id='.$postId);

include 'partials/bottom.php'; 

?>