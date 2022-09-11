<?php

    // This page runs when the user clicks the join household button

    session_start();

    include "database.php";
    require 'htmlChars.php';

    $data = new Database();

    // Gets the household name and password entered by the user

    $name = html($_REQUEST['name']);
    $password = html($_REQUEST['password']);
    $userID = html($_SESSION['id']);

    // Look for the household name in the database

    $stmt = $data->prepare("SELECT * FROM HOUSEHOLD WHERE name=:name"); 
    $stmt->bindValue(':name', $name, SQLITE3_TEXT); 
    $houses = $stmt->execute(); 

    $house = $houses->fetchArray();

    // If household is found and if the password matches, take the user to their houshold page
    // and change their household id to the id of the household
    // If user is not found, take them to the create household page
    // If password does not match, take them back to the join household page

    if (!empty($house))
    {
        if (password_verify($password, $house['password']))
        {
            $houseID = $house['householdID'];
            $data->exec("UPDATE USER SET householdID='$houseID' WHERE userID=$userID");
            header('location:household.php');
            die();
        } else {
            header('location:joinHousehold.php');
            die();
          }
    } else {
        header('location:createHousehold.php');
        die();
    }
?>