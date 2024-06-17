<?php 
require '_functions.php';
include 'partials/top.php'; 

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

foreach ($Uploads as $post) {

    echo  '<li>';
    
    $en=base64_encode($post['photo']);
    $mime=$post['title'];
    $binary_data='data:' . $mime . ';base64,' . $en ;
    ?>

    <img src=”<?php echo $binary_data; ?>” alt=”Test”>
    <?php

    echo  '<a href = item.php?id=' . $post['id'] . '>';
    echo  $post['title']; 
    echo  '</a></li>';

}




include 'partials/bottom.php'; 

?>