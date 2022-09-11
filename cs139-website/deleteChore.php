<?php

    // This page removes the chore from database when the user clicks 'delete chore' from the chore details page,
    // and navigates the user to their chores page

    require 'htmlChars.php';
    require 'database.php';
    $data = new Database();

    $choreID = html($_GET['id']);

    $stmt = $data->prepare("DELETE FROM CHORE WHERE choreID=:choreID"); 
    $stmt->bindValue(':choreID', $choreID, SQLITE3_INTEGER); 
    $stmt->execute(); 

    header("Location:chores.php");

?>