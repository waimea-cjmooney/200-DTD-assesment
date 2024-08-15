<?php
 
require 'lib/utils.php';
include 'partials/top.php'; 

$postId = $_GET['id'] ?? '';
$commentCode = $_GET['code'] ?? '';


echo '<h2>Commenting</h2>';


consoleLog($_POST, 'POST Data');

//Get form data
$words    = $_POST['words']; 
$date     = date("Y/m/d");
$pass     = $_POST['password'];


// Connect to database
$db = connectToDB();

// Set up a query to get all company info
$query = 'UPDATE Comments
          SET words=?, cDate=?
          WHERE code=? AND cPass=?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute( [ $words, $date, $commentCode, $pass ] );
    $item = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error adding data to the database');
}

echo '<p>Success<p>';

header('location: viewPost.php?id=' . $postId);

include 'partials/bottom.php'; 

?>