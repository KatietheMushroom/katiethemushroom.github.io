<?php

  // Page that lets the user register a new household
  // User has to be logged in to access this page

  session_start();

  require 'access.php';
  requireLogIn();  

  $userID = $_SESSION['id'];

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Create a Household</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/registerH.js"></script>
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php include_once 'menu.php' ?>
      <?php include_once 'summary.php' ?>
      <div class="content">

        <!-- Main Content: Form for creating a household, message boxes for error messages -->
        <h2>Create a Household</h2> 
        <hr><br/>
        <div class="form-box">
          <form id="form" method='post' action="newHousehold.php">

            <!-- Household name -->
            <p>
              <label for="name">Household Name: </label>
              <input type="text" name="name" id="name" placeholder="Name of your household...">
            </p>
            <div id="message1">
            </div>

            <!-- Household password -->
            <p>
              <label for="password">Household Password: </label>
              <input type="password" name="password" id="password" placeholder="Password for your household...">
            </p>
            <div id="message2">
            </div>

            <!-- Household password check -->
            <p>
              <label for="check_password">Re-Enter Password: </label>
              <input type="password" name="check_password" id="check_password" placeholder="Re-enter the password...">
            </p>
            <div id="message3">
            </div>
            <input type="submit" value="Make Household">
          </form>
        </div>
        <hr><br/>
      </div>
    </div>
  </body>
</html>
