
<?php 
require '_functions.php';
include 'partials/top.php'; 

$postId = $_GET['id'] ?? '';


echo '<h2>Commenting</h2>';


consoleLog($_POST, 'POST Data');

//Get form data
$words     = $_POST['words']; 
$cDate     = date("Y/m/d");
$password  = '123ABC';


// Connect to database
$db = connectToDB();

// Set up a query to get all company info
$query = 'INSERT INTO Comments
          (id, words, cDate, password)
          VALUES (?, ?, ?, ?)';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute( [ $postId, $words, $cDate, $password ] );
    $item = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error adding data to the database');
}

echo '<p>Success<p>';

header('location: viewPost.php?id=' . $postId);

include 'partials/bottom.php'; ?>