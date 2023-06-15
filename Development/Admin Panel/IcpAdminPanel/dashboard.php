<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  </head>
</head>
<body>

 <?php
    include_once "navigationBar.php";
 ?>

  
  <div class="row">
    <div class="col-sm-2">
      <?php
        include_once "sideBar.php";
      ?>
    </div>
    <div class="col-sm-10">
      <div class="container-fluid allContent-section"></div>
    </div>
    
  </div>
 
<script type="text/javascript" src="./ajaxDisplayPage.js"></script>
</body>
</html>
