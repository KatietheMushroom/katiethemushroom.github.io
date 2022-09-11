<?php

  // Page that displays all the chores in a household, and members of the household
  // User has to be logged in and in a house to access this page

  session_start();

  require 'access.php';
  require 'updateChores.php';
  requireLogIn();  
  requireHouse();

  $userID = $_SESSION['id'];

  // Gets the user's household id and updates its chores

  $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
  $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
  $users = $stmt->execute(); 

  $user = $users->fetchArray();

  $houseID = $user['householdID'];
  $today = new DateTime(date("Y-m-d"));

  update($houseID);

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Your Household</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/household.js"></script>
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php 
        include_once 'menu.php';
        include_once 'summary.php';
      ?>

      <!-- Tabs at the right to navigate between active, upcoming chores, and housemates -->
      <div class="content-wrapper">
        <div class="tab">
          <button id="tabA" class="tab"><span id="button-text">Active</span></button>
          <button id="tabB" class="tab"><span id="button-text">Upcoming</span></button>
          <button id="tabC" class="tab"><span id="button-text">Housemates</span></button>
        </div>
        <div class="tabcontent">

          <!-- Main Content: Household's chores, or its members -->
          <h2>Your Household</h2> 
          <hr><br/>
          <div id="chores">
          </div>
          <a class="button" id="add-task" href="https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/addChore.php">Add Chore</a>
          <hr><br/>
        </div>
      </div>
    </div>
  </body>
</html>
