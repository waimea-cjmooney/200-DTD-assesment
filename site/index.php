<?php 
require '_functions.php';
include 'partials/top.php'; 



// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get all uploads
$query = 'SELECT id, title, uploaded, descript FROM Uploads ORDER BY uploaded DESC';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $Uploads = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

// See what we get back
consoleLog($Uploads);

echo   '<a href = "formPost.php">New Post</a>';

echo '<ul id="post-list">';

foreach ($Uploads as $post) {

    echo  '<li>';

    echo  '<a href = viewPost.php?id=' . $post['id'] . '>';

    echo  '<img src="load-thing-image.php?id=' . $post['id'] . '">';
    echo  '<h2>' . $post['title'] . '<h2>';
    echo  '<h4>Uploaded ' . $post['uploaded'] . '<h4>';
    

    echo  '</a></li>';

}


echo '</ul>';

include 'partials/bottom.php'; 

?>