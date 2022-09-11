<?php

    // This adds a new household when the user submits the household registration form

    include "database.php";
    require "htmlChars.php";

    $data = new Database();

    // Get the user's information from the form

    $username = html($_REQUEST['username']);
    $email = html($_REQUEST['user_email']);
    $password = html($_REQUEST['password']);
    $check_password = html($_REQUEST['check_password']);

    $today = date("Y-m-d");

    // Check that there are no users with duplicate names

    $stmt = $data->prepare("SELECT COUNT(userID) FROM USER WHERE username=:username"); 
    $stmt->bindValue(':username', $username, SQLITE3_TEXT); 
    $count = $stmt->execute(); 

    $num = $count->fetchArray();

    // If count is not zero, user with the same name exists
    // Redirect the user back to user registration page

    if (array_pop($num) != 0) {
        header('Location:register.php');
        die();
    }

    // If all the fields are not empty and password matches the check, hash the password 
    // Add the household to the database

    if ($username && $email && $password && $check_password && $password == $check_password) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $data->prepare("INSERT INTO USER (username, nickname, email, password, dateJoined, iconID) VALUES (:username, :nickname, :email, :password, :dateJoined, :iconID)");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT); 
        $stmt->bindValue(':nickname', $username, SQLITE3_TEXT); 
        $stmt->bindValue(':email', $email, SQLITE3_TEXT); 
        $stmt->bindValue(':password', $password, SQLITE3_TEXT); 
        $stmt->bindValue(':dateJoined', $today, SQLITE3_TEXT); 
        $stmt->bindValue(':iconID', 1, SQLITE3_INTEGER);
        $stmt->execute();

        header('Location:login.php');
        die();
    } else {
        header('Location:register.php');
        die();
    }

?>
