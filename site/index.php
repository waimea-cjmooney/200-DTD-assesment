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

// Set up a query to get all company info
$query = 'SELECT * FROM ToDoList WHERE completed LIKE "0" ORDER BY priority DESC';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $ToDoList = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

// See what we get back
consoleLog($ToDoList);


echo '<ul id="ToDo">';


foreach ($ToDoList as $item) {

    echo  '<li> <span class="priority p' . $item['priority'] . '">';
    echo  $item['priority'];
    echo  '    </span>';


    echo  '<a href = item.php?id=' . $item['id'] . '>';
    echo  $item['name']; 
    echo  '</a>';

    echo '<a href="complete-item.php?id=' . $item['id'] . '" onclick="return confirm(`Complete task?`);">✕</a>';
    echo '</a>';
    echo '<a href="delete-item.php?id=' . $item['id'] . '" onclick="return confirm(`Delete task?`);">🗑</a>';
    echo '</a> </li>';

}

echo '</ul>';

echo '<h2> 
        <span class="completedHeading">
            Completed
        </span> 
      </h2>';

// Set up a query to get all company info
$query = 'SELECT * FROM ToDoList WHERE completed LIKE "1" ORDER BY priority DESC';

// Attempt to run the query
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $completed = $stmt->fetchAll();
}

catch (PDOException $e) {
    consoleLog($e->getMessage(), 'DB List Fetch', ERROR);
    die('There was an error getting data from the database');
}

// See what we get back
consoleLog($completed);


echo '<ul id="Done">';


foreach ($completed as $itemC) {

    echo  '<li> <span class="priority p' . $itemC['priority'] . '">';
    echo  $itemC['priority'];
    echo  '</span>';

    echo  '<a href = item.php?id=' . $itemC['id'] . '>';
    echo  $itemC['name']; 
    echo  '</a>';

    echo '<a href="complete-item.php?id=' . $itemC['id'] . '" onclick="return confirm(`Undo complete task?`);">✓</a>';
    echo '</a>';

    echo '<a href="delete-item.php?id=' . $itemC['id'] . '" onclick="return confirm(`Delete task?`);">🗑</a>';
    echo '</a> </li>';

}

echo '</ul>';


include 'partials/bottom.php'; 

echo '<div id = "Add-button">
        <a href = "form-item.php">
            Add
        </a>
     </div>';

?>