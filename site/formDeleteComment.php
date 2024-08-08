<?php

require 'lib/utils.php';
include 'partials/top.php';

$commentCode = $_GET['code'] ?? '';
$postId = $_GET['id'] ?? '';

// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get comment info
$query = 'SELECT code, id, words, cDate FROM Comments WHERE code = ?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute([$commentCode]); // Pass in the data
    $post = $stmt->fetch();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

if ($post == false) die('Item with code: ' . $commentCode . ' does not exist.');


echo '<a href="viewPost.php?id=' . $post["id"] . '">Back</a> <br>';



// Form for deleting comment
?>

<form method = "post" action = <?php echo '"deleteComment.php?code=' . $commentCode . '&id=' . $postId . '"' ?> >

       <label>Password</label>
       <input name = 'Password'
              type = 'Password' 
              required>

       <input type="submit" 
              value="Delete" onclick="return confirm(`Delete comment? (This cannot be undone. All reports on this post will also be deleted.)`);">

</form>

<?php

// Display comment

echo  '<ul id="comment">';

echo  '<img src="images/User.png" style="height: 1rem; width: 1rem;">';
echo  ' Anonymous ' . $post['cDate'];
echo  '<br>';
echo   $post['words'];

echo '</ul>';





include 'partials/bottom.php';