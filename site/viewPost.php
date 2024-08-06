<?php

require 'lib/utils.php';
include 'partials/top.php';

$postId = $_GET['id'] ?? '';

// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get all post info
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

if ($post == false) die('Post with id: ' . $postId . ' does not exist.');


echo '<a href="index.php">Back</a> <br>';



echo '<ul id="post-view">';

echo '<div id="postViewDate">' . $post['uploaded'];
echo '<div id="postLinks"> <a href="formReport.php?id=' . $postId . '" title="Report">⚑</a> 
                           <a href="formEditPost.php?id=' . $postId . '" title="Edit">✎</a> 
                           <a href="formDeletePost.php?id=' . $postId . '" title="Delete" style="font-weight: bolder;" >🗑</a></div>';
echo '<h2> ' . $post['title'] . '</h2>';
echo '<img src="load-thing-image.php?id=' . $postId . '"><br>';
echo '<h3>' . $post['descript'] . '</h3>';


echo '</ul>';



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

        <input name = 'password'
               type = 'password' 
               placeholder = 'Password' 
               required
               oninvalid="this.setCustomValidity('A password is required')"
               oninput="this.setCustomValidity('')">

        <input type="submit" 
               value="Submit">

</form>



<?php



foreach ($comments as $comment) {

    echo  '<li>';

    echo  '<ul id="comment">';

    echo  '<img src="images/User.png" style="height: 1rem; width: 1rem;">';
    echo  ' Anonymous ' . $comment['cDate'];
    echo  '<br>';
    echo  '<a href="formCommentReport.php?id=' . $comment['code'] . '" title="Report">⚑</a>
           <a href="formCommentEdit.php?id='   . $comment['code'] . '" title="Edit"  >✎</a>
           <a href="formDeleteComment.php?code='    . $comment['code'] . '" title="Delete"
           style="font-weight: bolder;" >🗑</a>';
    echo  '<br>';
    echo  $comment['words'];

    echo  '</ul></li>';

}




include 'partials/bottom.php';
