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

echo '<p>' . $post['uploaded'] . '</p>';
echo '<div id="postLinks" style="display: flex;"> 
                           <a href="formReport.php?id='     . $postId . '" title="Report"> <img src="images/report.png" style="width: 24px; border-radius: 0px;" > </a> 
                           <a href="formEditPost.php?id='   . $postId . '" title="Edit">   <img src="images/edit.png"   style="width: 20px; border-radius: 0px; padding: 0px 2px 2px 0px;" > </a> 
                           <a href="formDeletePost.php?id=' . $postId . '" title="Delete"> <img src="images/trash.png"  style="width: 17px; border-radius: 0px;" > </a></div>';
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
    echo  '<a href="formCommentReport.php?id='   . $comment['code'] . '&id=' . $postId . '" title="Report"> <img src="images/report.png" style="width: 24px; background-color: transparent; border-radius: 0px;" > </a>
           <a href="formCommentEdit.php?id='     . $comment['code'] . '&id=' . $postId . '" title="Edit"  > <img src="images/edit.png"   style="width: 17px; background-color: transparent; border-radius: 0px; padding-left: 0px;" > </a>
           <a href="formDeleteComment.php?code=' . $comment['code'] . '&id=' . $postId . '" title="Delete" > <img src="images/trash.png"  style="width: 17px; background-color: transparent; border-radius: 0px;" ></a>';
    echo  '<br>';
    echo  $comment['words'];

    echo  '</ul></li>';

}




include 'partials/bottom.php';
