<?php

require 'lib/utils.php';
include 'partials/top.php';

$postId = $_GET['id'] ?? '';
$commentCode = $_GET['code'] ?? '';

// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get all post info
$query = 'SELECT code, words, cDate FROM Comments WHERE code = ?';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute([$commentCode]); // Pass in the data
    $comment = $stmt->fetch();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

if ($comment == false) die('Item with id: ' . $commentCode . ' does not exist.');


echo '<a href="viewPost.php?id=' . $postId . '">Back</a> <br>';

consoleLog($comment)

?>

<form method = "post" action = <?php echo '"addEditComment.php?code=' . $commentCode  . '&id=' . $postId . '"' ?> >

       <h2>Edit Comment</h2>

       <label>Comment</label>
       <textarea name = 'words'
              type = 'text'
              <?php echo 'required>' . $comment['words'] . '</textarea>' ?>

       <input name = 'password'
              type = 'password' 
              placeholder = 'Password'
              oninvalid="this.setCustomValidity('The password is required')"
              required>

       <input type="submit" 
              value="Confirm">

</form>

<?php

echo '<ul id="comment">';

echo  '<img src="images/User.png" style="height: 1rem; width: 1rem;">';
echo  ' Anonymous ' . $comment['cDate'];
echo  '<br>';
echo  $comment['words'];

echo  '</ul>';


include 'partials/bottom.php';