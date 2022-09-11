<?php

  // Page that displays the details of a chore, such as the description, date due, etc.
  // User has to be logged in and in a house to access this page

  session_start();

  require_once 'access.php';
  requireLogIn();  
  requireHouse();

  $userID = $_SESSION['id'];

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Chore</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php include_once 'menu.php' ?>
      <?php include_once 'summary.php' ?>
      <div class="content">

        <?php

          // Get the correct chore from header

          $stmt = $data->prepare("SELECT * FROM CHORE WHERE choreID=:choreID"); 
          $stmt->bindValue(':choreID', $_GET['id'], SQLITE3_INTEGER); 
          $chores = $stmt->execute(); 

          $chore = $chores->fetchArray();
          $creatorID = $chore['creatorID'];

          // Used to get the nickname of the creator

          $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:creatorID"); 
          $stmt->bindValue(':creatorID', $creatorID, SQLITE3_INTEGER); 
          $creators = $stmt->execute(); 
          $creator = $creators->fetchArray();

          $html = "<h2>".$chore['task']."</h2><hr><br/><div class='info'>";

          $note = $chore['note'];
          $date = $chore['dateAdded'];
          $frequency = $chore['frequency'];
          $status = $chore['status'];
          $forID = $chore['userID'];

          // Used to get the nickname of the user

          $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
          $stmt->bindValue(':userID', $forID, SQLITE3_INTEGER); 
          $users = $stmt->execute(); 
          $user = $users->fetchArray();

          // Display in different formats for weekly/monthly chores

          if ($frequency == "Weekly") {
            $frequency .= " on ".date('l', strtotime($chore['dateDue']));
          } else if ($frequency == "Monthly") {
            $frequency .= " on the ".date('jS', strtotime($chore['dateDue'])); 
          }

          // Display the relevant information for the chore

          $html .= "<p>Description: ".$note."</p><p>Allocated to: ".$user['nickname']."</p><p>Created by: ".$creator['nickname']." on ".$date.
          "</p><p>Frequency: ".$frequency."</p><p>Status: ".$status."</p><p id='bottom'>Next Due on: ".$chore['dateDue']."</p>";

          // Complete, delete, back to chores and back to houshold buttons

          $html .= "<br/><a href='https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/taskDone2.php?id=".$chore['choreID']."'><button class='complete'>Done!</button></a>

          <a href='https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/deleteChore.php?id=".$chore['choreID']."'><button class='delete'>Delete Chore</button></a>
          
          <a href='https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/chores.php'><button id='back'>Back to Chores -&gt;</button></a>

          <a href='https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/household.php'><button id='back'>Back to Household -&gt;</button></a>";

          echo $html;
        ?>

        </div>
        <hr><br/>
      </div>
    </div>
  </body>
</html>
