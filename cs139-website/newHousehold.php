<?php

    // This adds a new household when the user submits the household registration form
    // Only accessible if you are logged in and in a household

    session_start();

    require "htmlChars.php";
    require 'access.php';
    requireLogIn();

    // Get the household's information from the form

    $name = html($_REQUEST['name']);
    $password = html($_REQUEST['password']);
    $check_password = html($_REQUEST['check_password']);

    $today = date("Y-m-d");

    // Check that there are no households with duplicate names

    $stmt = $data->prepare("SELECT COUNT(householdID) FROM HOUSEHOLD WHERE name=:name"); 
    $stmt->bindValue(':name', $name, SQLITE3_TEXT); 
    $count = $stmt->execute(); 

    $num = $count->fetchArray();

    // If count is not zero, household with the same name exists
    // Redirect the user back to household registration page

    if (array_pop($num) != 0) {
        header('Location:createHousehold.php');
    }

    // If all the fields are not empty and password matches the check, hash the password 
    // Add the household to the database

    if ($name && $password && $check_password && $password == $check_password) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $data->prepare("INSERT INTO HOUSEHOLD (name, password, dateCreated) VALUES (:name, :password, :dateCreated)");
        $stmt->bindValue(':name', $name, SQLITE3_TEXT); 
        $stmt->bindValue(':password', $password, SQLITE3_TEXT); 
        $stmt->bindValue(':dateCreated', $today, SQLITE3_TEXT); 
        $stmt->execute();

        header('Location:joinHousehold.php');
        die();
    } else {
        header('Location:createHousehold.php');
        die();
    }

?>
