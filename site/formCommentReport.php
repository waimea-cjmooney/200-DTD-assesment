<?php

require 'lib/utils.php';
include 'partials/top.php';

$commentCode = $_GET['code'] ?? '';

// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get all post info
$query = 'SELECT code, id, words, cDate FROM Comments WHERE code = ?';

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


echo '<a href="viewPost.php?id=' . $comment['id'] . '">Back</a> <br>';

?>



<form method = "post" action = <?php echo '"reportComment.php?code=' . $commentCode . '&id=' . $comment['id'] . '"' ?> >

       <h2>Report</h2>

       <label>Email</label>
       <input name = 'email'
              type = 'email'
              placeholder = 'e.g. Example@email.com'
              oninvalid="this.setCustomValidity('An email is required')"
              required>

       <label>Reason for the report</label>
       <textarea name = 'reason'
              required></textarea>

       <input type="submit" 
              value="Post" onclick="return confirm(`Report post? (This cannot be undone)`);">

</form>

<?php

echo '<ul id="comment">';

echo  '<img src="images/User.png" style="height: 1rem; width: 1rem;">';
echo  ' Anonymous ' . $comment['cDate'];
echo  '<br>';
echo  $comment['words'];

echo  '</ul>';





include 'partials/bottom.php';