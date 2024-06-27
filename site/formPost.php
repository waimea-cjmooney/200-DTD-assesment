<?php 
require '_functions.php';
include 'partials/top.php'; 
?>


<h2>New Post</h2>

<form method = 'post' action = 'addPost.php' enctype="multipart/form-data">

       <label>Title</label>
       <input name = 'title'
              type = 'text' 
              placeholder = 'e.g. My cat' 
              required>

       <label>Description</label>
       <textarea name = 'descript'
              required></textarea>

       <input type = "file" 
              name = "image" 
              accept = "image/*" 
              required>

       <label>Password</label>
       <input name = 'password'
              type = 'text' 
              required>

       <input type="submit" 
              value="Post">


<?php
include 'partials/bottom.php';
?>