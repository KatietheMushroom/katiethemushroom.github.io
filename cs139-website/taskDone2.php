<?php

    require 'htmlChars.php';
    require 'database.php';
    $data = new Database();

    $choreID = html($_GET['id']);

    // Find the chore
    $stmt = $data->prepare("SELECT * FROM CHORE WHERE choreID=:choreID"); 
    $stmt->bindValue(':choreID', $choreID, SQLITE3_INTEGER); 
    $chores = $stmt->execute(); 
    $chore = $chores->fetchArray();

    // Remove completed overdue chore, as there is already a copy of it 
    // Or non-repeating onces
    if ($chore['status'] == 'Overdue' || $chore['frequency'] == 'Once') {
        $data->exec("DELETE FROM CHORE WHERE choreID=$choreID");
    } 
    
    // For non-overdue chores, change the date due to the next one and increment repeatCount
    else {
        $dateDue = new DateTime($chore['dateDue']);
        $dateDue->modify('+ '.$chore['interval'].' day');
        $due = $dateDue->format('Y-m-d');

        $stmt = $data->prepare("UPDATE CHORE SET status=:status, dateDue=:dateDue WHERE choreID=:choreID"); 
        $stmt->bindValue(':choreID', $choreID, SQLITE3_INTEGER); 
        $stmt->bindValue(':status', 'Complete', SQLITE3_TEXT);
        $stmt->bindValue(':dateDue', $due, SQLITE3_TEXT); 
        $stmt->execute(); 
    }

    header("Location:chores.php");

?>
