<?php 
require '_functions.php';
include 'partials/top.php'; 


echo '<h2> 
        <span class="completedHeading">
            Not Completed
        </span> 
      </h2>';

// Connect to database
$db = connectToDB();
consoleLog($db);

// Set up a query to get all uploads
$query = 'SELECT * FROM Uploads';

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


echo '<ul id="ToDo">';


foreach ($Uploads as $post) {

    echo  '<li>';
    echo  $post['priority'];

    echo  '<a href = item.php?id=' . $post['id'] . '>';
    echo  $post['title']; 
    echo  '</a>';

}

echo '</ul>';



include 'partials/bottom.php'; 

echo '<div id = "Add-button">
        <a href = "form-item.php">
            Add
        </a>
     </div>';

?>