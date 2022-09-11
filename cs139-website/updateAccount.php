<?php

  // This updates the user's nickname when they click update on the account page
  // User must be logged in to access this

  session_start();

  require 'access.php';
  requireLogin();

  require 'htmlChars.php';

  // Get user id from the session and nickname from the form 

  $userID = $_SESSION['id'];
  $nickname = html($_POST['nickname']);

  // Set the user's new nickname and redirect to account page

  $stmt = $data->prepare("UPDATE USER SET nickname=:nickname WHERE userID=:userID"); 
  $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
  $stmt->bindValue(':nickname', $nickname, SQLITE3_TEXT);
  $stmt->execute(); 

  header("Location:account.php");

?>