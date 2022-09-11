<?php

  // This is called when the user clicks on an icon in the account page
  // It updates the icon and is only accessible if logged in

  session_start();

  require 'access.php';
  requireLogin();

  require 'htmlChars.php';

  // Get the new icon id from header

  $userID = $_SESSION['id'];
  $iconID = html($_GET['id']);

  // Set the icon id to the new icon id and redirect back to account

  $stmt = $data->prepare("UPDATE USER SET iconID=:iconID WHERE userID=:userID"); 
  $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
  $stmt->bindValue(':iconID', $iconID, SQLITE3_TEXT);
  $stmt->execute(); 

  header("Location:account.php");

?>