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


echo $post['uploaded'];
echo '<h2> ' . $post['title'] . '</h2>';
echo '<img src="load-thing-image.php?id=' . $postId . '">';
echo '<br>';
echo '<h3>' . $post['descript'] . '</h3>';


// Set up a query to get all comments
$query = 'SELECT code, words, cDate FROM Comments WHERE id = ?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute([$postId]);
    $comments = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

// See what we get back
consoleLog($comments);


// Comments
?>

<form method = 'post' action = <?php echo 'addComment.php?id=' . $postId ?>>

       <input name = 'words'
              type = 'text' 
              placeholder = 'Comment' 
              required>

       <input type="submit" 
              value="Submit">

</form>

<?php


foreach ($comments as $comment) {

    echo  '<li>';

    echo  'Anonymous ' . $comment['cDate'];
    echo  '<br>';
    echo  $comment['words'];

    echo  '</a></li>';
    echo  '<br>';

}


include 'partials/bottom.php';