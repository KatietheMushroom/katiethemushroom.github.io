<?php

    session_start();

    include "database.php";

    $data = new Database();

    $userID = $_SESSION['id'];

    // Retrieve the household id from database

    $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
    $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
    $users = $stmt->execute(); 

    $user = $users->fetchArray();

    $houseID = $user['householdID'];

    // Select all users from the household

    $stmt = $data->prepare("SELECT * FROM USER WHERE householdID=:houseID"); 
    $stmt->bindValue(':houseID', $houseID, SQLITE3_INTEGER); 
    $members = $stmt->execute(); 

    $html = "<h3>Your Housemates</h3>";

    $empty = TRUE;

    // Add the icon and nickname of every housemate into the html

    while ( ($row = $members->fetchArray() ))
    {
        $empty = FALSE;

        $html .= "<div class='member'><div class='iconBigger'><img src='img/".$row['iconID'].".jpg' alt='icon ".$row['iconID']."'></div><p><b>".$row['nickname']."</b></p></div>";
    }

    echo $html;
?>
