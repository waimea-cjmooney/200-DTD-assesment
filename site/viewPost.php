<?php

require '_functions.php';
include 'partials/top.php';

$postId = $_GET['id'] ?? '';

// SQL we need to get the company info...
// SELECT * FROM companirs WHERE code = XXX

// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get all company info
$query = 'SELECT id, title, uploaded, descript FROM Uploads WHERE id = ?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute([$postId]); // Pass in the data
    $post = $stmt->fetch();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

if ($post == false) die('Item with this id: ' . $postId . ' does not exist.');



echo '<h2> ' . $post['title'] . '</h2>';
echo '<img src="load-thing-image.php?id=' . $post['id'] . '">';



include 'partials/bottom.php';