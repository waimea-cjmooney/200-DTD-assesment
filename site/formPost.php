<?php 
require 'lib/utils.php';
include 'partials/top.php'; 
?>

<a href="index.php">Back</a> <br>

<form method = 'post' action = 'addPost.php' enctype="multipart/form-data">

       <h2>New Post</h2>

       <label>Title</label>
       <input name = 'title'
              type = 'text' 
              placeholder = 'e.g. My cat' 
              maxlength="50"
              required>

       <label>Description</label>
       <textarea name = 'descript'
              required
              maxlength="250"></textarea>

       
       <label>Upload File</label>
       <input hidden
              id = 'file-upload'
              type = "file" 
              name = "image" 
              accept = "image/*" 
              required
              >

       <label>Password</label>
       <input name = 'password'
              type = 'password'
              maxlength="25" 
              oninvalid="this.setCustomValidity('A password is required')"
              required>

       <input type="submit" 
              value="Post">


<?php
include 'partials/bottom.php';
?>