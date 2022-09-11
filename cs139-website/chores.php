<?php

  // Page that displays chores that belong to the user
  // User has to be logged in and in a house to access this page

  session_start();

  require 'access.php';
  require 'updateChores.php';
  requireLogIn();
  requireHouse();

  $userID = $_SESSION['id'];

  // Retrieve the household id from database

  $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
  $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
  $users = $stmt->execute(); 

  $user = $users->fetchArray();

  $houseID = $user['householdID'];
  $today = new DateTime(date("Y-m-d"));

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Your Chores</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/chores.js"></script>
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php include_once 'menu.php' ?>
      <?php include_once 'summary.php' ?>

      <!-- Tabs at the right to navigate between active and upcoming chores -->
      <div class="content-wrapper">
        <div class="tab">
          <button id="tabA" class="tab"><span id="button-text">Active</span></button>
          <button id="tabB" class="tab"><span id="button-text">Upcoming</span></button>
        </div>
        <div class="tabcontent">

          <!-- Main Content: User's chores -->
          <h2>Your Chores</h2> 
          <hr><br/>
          <div id="chores">
          </div>
          <hr><br/>
        </div>
      </div>
    </div>
  </body>
</html>
