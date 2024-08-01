<?php
 
require 'lib/utils.php';
include 'partials/top.php'; 

$postId = $_GET['id'] ?? '';


echo '<h2>Commenting</h2>';


consoleLog($_POST, 'POST Data');

//Get form data
$title    = $_POST['title']; 
$date     = date("Y/m/d");
$descript = $_POST['description'];
$pass     = $_POST['password'];


// Connect to database
$db = connectToDB();

// Set up a query to get all company info
$query = 'UPDATE Uploads
          SET title=?, descript=?, uploaded=?
          WHERE id=? AND pass=?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute( [ $title, $descript, $date, $postId, $pass ] );
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