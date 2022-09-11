<?php

  // This displays a sidebar with the user's icon, their next chore, and household info
  // User has to be logged in to access this page

  requireLogIn();  
  include_once "updateChores.php";

  $userID = $_SESSION['id'];

  // Get the user's information from database

  $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
  $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
  $users = $stmt->execute(); 
  $user = $users->fetchArray();

  // If their household id is set, update its chores and select the first chore belonging to them

  $houseID = $user['householdID'];

  if (isset($houseID)) {
    $today = new DateTime(date("Y-m-d"));

    $stmt = $data->prepare("SELECT * FROM HOUSEHOLD WHERE householdID=:houseID"); 
    $stmt->bindValue(':houseID', $houseID, SQLITE3_INTEGER); 
    $houses = $stmt->execute(); 
    $house = $houses->fetchArray();

    update($houseID);

    $stmt = $data->prepare("SELECT * FROM CHORE WHERE userID=:userID ORDER BY dateDue"); 
    $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
    $stmt->bindValue(':today', date("Y-m-d"), SQLITE3_TEXT);
    $stmt->bindValue(':status', 'Overdue', SQLITE3_TEXT);  
    $chores = $stmt->execute(); 

    $chore = $chores->fetchArray();
  }

?>

<!-- Displays the sidebar with icon, nickname, house and next chore -->

<div class="sidebar">
    <div class="image-box"><a href="https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/account.php"><img src="img/<?php echo $user['iconID']?>.jpg" alt="icon 1"></a></div>
    <h3><a href="https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/account.php"><?php echo $user['nickname'] ?></a></h3>
        <ul>
            <?php
              // If user is not in a house, display a message for that instead
              if (!isset($houseID)) {
                echo "<li>You're not currently in a house. Join one today! </li>";
              } else {
                echo "<li><b>House:</b> ".$house['name']."</li><li><b>Next chore:</b> ";
                if (empty($chore)) {
                  echo "Yay! You have no chores to do!</li>";
                } else {
                  echo $chore['task']." <br><b>Due:</b> ".$chore['dateDue']."</li>";
                }
              }
            ?>
        </ul>
</div>
