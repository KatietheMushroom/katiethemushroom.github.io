<?php

    // Page that allows the user to add a chore to their household
    // User has to be logged in and in a house to access this page

    session_start();

    require 'access.php';
    requireLogin();
    requireHouse();
  
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Add a Chore</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/choreForm.js"></script>
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php include_once 'menu.php' ?>
      <?php include_once 'summary.php' ?>
      <div class="content">

        <!-- Main Content: Form to add a chore -->
        <h2>Add a Chore</h2> 
        <hr><br/>

        <!-- Form for submitting a chore -->
        <div class="form-box">
          <form method='post' action="newChore.php">

            <!-- Chore name -->
            <p>
              <label for="task">Title of Chore: </label>
              <input type="text" name="task" id="task" placeholder="Title for your chore...">
            </p>

            <!-- Chore description -->
            <p>
              <label for="note">Description: </label>
              <input type="text" name="note" id="note" placeholder="Describe your chore...">
            </p>

            <!-- Weight of chore, with pre-set values -->
            <p>
              <label for="weight">How big is the task? </label>
              <select name="weight" id="weight">
                <option value=100>Small</option>
                <option value=400>Medium</option>
                <option value=1000>Large</option>
              </select>
            </p>

            <!-- Chore frequency, selecting 'custom' shows interval field -->
            <p>
              <label for="frequency">Frequency: </label>
              <select name="frequency" id="frequency">
                <option value="Once">Once</option>
                <option value="Daily">Daily</option>
                <option value="Weekly">Weekly</option>
                <option value="Monthly">Monthly</option>
                <option value="Custom">Every x days</option>
              </select>
            </p>

            <!-- Chore interval, only displayed for custom intervals -->
            <p>
              <label for="interval" id="interval-label">Interval: </label>
              <input type="number" name="interval" id="interval" min="1" max="300" value="7">
            </p>
            
            <!-- The first day the chore is due -->
            <p>
              <label for="date">Date to start: </label>
              <input type="date" id="date" name="date" min="<?php echo date("Y-m-d") ?>" value="<?php echo date("Y-m-d") ?>">
            </p>
            <input type="submit" value="Add Chore">
          </form>
        </div>
        <hr><br/>
      </div>
    </div>
  </body>
</html>