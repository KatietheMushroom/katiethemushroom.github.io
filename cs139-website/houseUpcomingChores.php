<?php

    // Produces the required html for displaying the user's household's upcoming chores
    // User has to be logged in and in a house to access this page

    session_start();

    include "database.php";
    include "updateChores.php";

    $data = new Database();

    $userID = $_SESSION['id'];

    // Retrieve the household id from database

    $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
    $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
    $users = $stmt->execute(); 

    $user = $users->fetchArray();

    $houseID = $user['householdID'];
    $today = new DateTime(date("Y-m-d"));

    // Update the household's current & upcoming chores

    update($houseID);

    // Select all upcoming chores (due tomorrow or after) that belong to the user's household ordered by date

    $stmt = $data->prepare("SELECT * FROM CHORE WHERE householdID=:houseID AND (NOT dateDue=:today) AND (NOT status=:status) ORDER BY dateDue"); 
    $stmt->bindValue(':houseID', $houseID, SQLITE3_INTEGER); 
    $stmt->bindValue(':today', date("Y-m-d"), SQLITE3_TEXT);
    $stmt->bindValue(':status', 'Overdue', SQLITE3_TEXT);  
    $chores = $stmt->execute();

    // Construct the html for display in the page

    $html = "<h3>Upcoming Chores</h3><table>";

    $empty = TRUE;

    while ( ($row = $chores->fetchArray() ))
    {

        $empty = FALSE;

        // Fetch the icon of the user who the chore belongs to

        $stmt = $data->prepare("SELECT * FROM USER WHERE userID = :userID"); 
        $stmt->bindValue(':userID', $row['userID'], SQLITE3_INTEGER); 
        $victims = $stmt->execute();
        $victim = $victims->fetchArray();

        // Change due date to an appropriate display e.g. 'Tomorrow' or 'Sunday' based on the date today
            
        $due = new DateTime($row['dateDue']);
        $interval = $due->diff($today)->format('%a');
        if ($interval == 1) {
            $due = "Tomorrow";
        } else if ($interval < 8) {
            $due = date('l', strtotime($row['dateDue']));
        } else if ($interval < 15) {
            $due = date('\N\e\x\t l', strtotime($row['dateDue']));
        } else {
            $due = $row['dateDue'];
        }
        $html.="<tr id='".$row['choreID']."'><td><div class='icon'><img src='img/".$victim['iconID'].".jpg' alt='icon ".$victim['iconID']."'></div></td><td><b>".$row['task']."</b></td><td>".$row['status']."</td><td>Due ".$due."</td><td><button class='complete' id='".$row['choreID']."'>Complete!</td></tr>";
    }
    $html.="</table>";

    // If there are no upcoming chores, replace html with just the title and a message

    if ($empty) {
        $html = "<h3>Active Chores</h3><p id='center'>There are no upcoming chores in your household :)</p>";
    }

    echo $html;
?>