<?php

  // This page is the login page for households, essentially
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
    <title>DO. - Join a Household</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php include_once 'menu.php' ?>
      <?php include_once 'summary.php' ?>

      <!-- Main Content: Form to join a household -->
      <div class="content">
        <h2>Join a Household</h2> 
        <hr><br/>
        <div class="form-box">
          <form method='post' action="authenticateH.php">

            <!-- Household name -->
            <p>
              <label for="name">Household Name: </label>
              <input type="text" name="name" id="name" placeholder="Name of the household...">
            </p>

            <!-- Household password -->
            <p>
              <label for="password">Household Password: </label>
              <input type="password" name="password" id="password" placeholder="Password of the household...">
            </p>
            <input type="submit" value="Join Household">
          </form>
          <p style="padding-left:15px">First member? Create a household <a href='https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/createHousehold.php'>here</a>.</p>
        </div>
        <hr><br/>
      </div>
    </div>
  </body>
</html>
