<?php 
require_once '_config.php';

$page = basename($_SERVER['SCRIPT_NAME']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= SITE_NAME ?> </title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    
    <header>
        <h1> <a href = 'index.php'><?= SITE_NAME ?></a> </h1>

        <nav>
            <a href = 'index.php'     class='<?= $page=='index.php'     ? 'active' : '' ?>'>Home</a>

        </nav>
    </header>
<main>