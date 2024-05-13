
<?php require_once '_config.php'; ?>

<?php

$page = basename($_SERVER['SCRIPT_NAME']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= SITE_NAME ?> </title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    
    <header>
        <h1> <?= SITE_NAME ?> </h1>

        <nav>
            <a href = 'index.php'     class='<?= $page=='index.php'     ? 'active' : '' ?>'>Home</a>

        </nav>
    </header>
<main>