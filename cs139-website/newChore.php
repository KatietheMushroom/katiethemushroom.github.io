<?php

  // This adds a new chore when the addChore form is submitted
  // Only accessible if you are logged in and in a household

  session_start();

  require 'htmlChars.php';
  require 'access.php';
  require 'userBusy.php';
  requireLogIn();
  requireHouse();

  $creatorID = $_SESSION['id'];

  // Requests all the information needed from the form

  $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
  $stmt->bindValue(':userID', $creatorID, SQLITE3_INTEGER); 
  $creators = $stmt->execute(); 

  $creator = $creators->fetchArray();

  $householdID = $creator['householdID'];

  $task = html($_REQUEST['task']);
  $note = html($_REQUEST['note']);
  $frequency = html($_REQUEST['frequency']);
  $interval = html($_REQUEST['interval']);
  $starting = html($_REQUEST['date']);
  $today = date("Y-m-d");
  $weight = html($_REQUEST['weight']);

  // Set interval according to the user's choice of frequency

  if ($frequency == 'Daily') {
    $interval = 1;
  } else if ($frequency == 'Weekly') {
    $interval = 7;
  } else if ($frequency == 'Monthly') {
    $interval = 30;
  } else if ($frequency == 'Once') {
    $interval = NULL;
  }

  // Weigh the chore based on its difficulty and its frequency

  if ($frequency != 'Once') $weight = intdiv($weight, $interval);
  else $weight = intdiv($weight, 40);

  $stmt = $data->prepare("SELECT * FROM USER WHERE householdID=:householdID"); 
  $stmt->bindValue(':householdID', $householdID, SQLITE3_INTEGER); 
  $allUsers = $stmt->execute(); 
  $users = array();

  // Allocated chore to the user with the least total weight

  $victimID = leastBusy($householdID);

  // Insert the chore

  $stmt = $data->prepare("INSERT INTO CHORE (householdID, userID, creatorID, task, note, dateAdded, status, frequency, interval, starting, dateDue, weight) 
  VALUES (:householdID, :userID, :creatorID, :task, :note, :today, :status, :frequency, :interval, :starting, :dateDue, :weight)");
  $stmt->bindValue(':householdID', $householdID, SQLITE3_INTEGER); 
  $stmt->bindValue(':userID', $victimID, SQLITE3_INTEGER); 
  $stmt->bindValue(':creatorID', $creatorID, SQLITE3_INTEGER); 
  $stmt->bindValue(':task', $task, SQLITE3_TEXT); 
  $stmt->bindValue(':note', $note, SQLITE3_TEXT); 
  $stmt->bindValue(':today', $today, SQLITE3_TEXT); 
  $stmt->bindValue(':status', 'Incomplete', SQLITE3_TEXT); 
  $stmt->bindValue(':frequency', $frequency, SQLITE3_TEXT); 
  $stmt->bindValue(':interval', $interval, SQLITE3_INTEGER); 
  $stmt->bindValue(':starting', $starting, SQLITE3_TEXT); 
  $stmt->bindValue(':dateDue', $starting, SQLITE3_TEXT);
  $stmt->bindValue(':weight', $weight, SQLITE3_INTEGER);  
  $stmt->execute();

  $stmt = $data->prepare("SELECT MAX(choreID) FROM CHORE"); 
  $lastID = $stmt->execute(); 
  $lastID = $lastID->fetchArray();

  // Redirects to the details of this chore

  header('Location:chore.php?id='.$lastID[0]);
  die();

?>
