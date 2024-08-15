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

if ($post == false) die('Item with id: ' . $postId . ' does not exist.');


echo '<a href="viewPost.php?id=' . $postId . '">Back</a> <br>';

?>

<form method = "post" action = <?php echo '"addEdit.php?id=' . $postId  . '"' ?> >

       <h2>Edit post</h2>

       <label>Title</label>
       <input name = 'title'
              type = 'text' 
  <?php echo 'value = "' . $post['title'] . '"'?>
              required>

       <label>Description</label>
<?php echo "<textarea name = 'description'
                      required>" . $post['descript'] . "</textarea>" ?>

       <label>Password</label>
       <input name = 'password'
              type = 'password' 
              oninvalid="this.setCustomValidity('The password is required')"
              required>

       <input type="submit" 
              value="Confirm">

</form>

<?php

echo '<ul id="post-view">';

echo $post['uploaded'];
echo '<h2> ' . $post['title'] . '</h2>';
echo '<img src="load-thing-image.php?id=' . $postId . '"><br>';
echo '<h3>' . $post['descript'] . '</h3>';

echo '</ul>';





include 'partials/bottom.php';