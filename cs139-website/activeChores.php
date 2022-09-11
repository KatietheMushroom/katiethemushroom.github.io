<?php

    // Produces the required html for displaying the user's active chores
    // User has to be logged in and in a house to access this page

    session_start();

    require 'access.php';
    require 'updateChores.php';
    requireLogIn();
    requireHouse();

    $userID = $_SESSION['id'];
    
    $today = new DateTime(date("Y-m-d"));

    // Retrieve the household id from database

    $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
    $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
    $users = $stmt->execute(); 

    $user = $users->fetchArray();

    $houseID = $user['householdID'];
    $today = new DateTime(date("Y-m-d"));

    // Update the household's current & upcoming chores

    update($houseID);

    // Select all active chores (due today or overdue) that belong to the user ordered by date

    $stmt = $data->prepare("SELECT * FROM CHORE WHERE userID=:userID AND (dateDue=:today OR status=:status) ORDER BY dateDue"); 
    $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
    $stmt->bindValue(':today', date("Y-m-d"), SQLITE3_TEXT);
    $stmt->bindValue(':status', 'Overdue', SQLITE3_TEXT);  
    $chores = $stmt->execute(); 

    // Construct the html for display in the page

    $html = "<h3>Active chores</h3><table>";

    $empty = TRUE;

    while ( ($row = $chores->fetchArray() ))
    {
        $empty = FALSE;

        // Display an overdue warning and display the due date if overdue
        // Otherwise display due date as 'Today'

        if ($row['status'] == 'Overdue') {
            $due = $row['dateDue'];
            $status = "! Overdue !";
        } else {
            $due = 'Today';
            $status = $row['status'];
    }
    $html.="<tr id='".$row['choreID']."'><td><b>".$row['task']."</b></td><td>".$status."</td><td>Due ".$due."</td><td><button class='complete' id='".$row['choreID']."'>Complete!</td></tr>";
    }
    $html.="</table>";

    // If there are no active chores, replace html with just the title and a message

    if ($empty) {
        $html = "<h3>Active Chores</h3><p id='center'>You have no active chores :)</p>";
    }

    echo $html;
?>