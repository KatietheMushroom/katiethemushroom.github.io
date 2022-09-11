<?php

    // This page runs when the user clicks the login button

    session_start();

    include "database.php";
    require 'htmlChars.php';

    $data = new Database();

    // Gets the username and password entered by the user

    $username = html($_REQUEST['username']);
    $password = html($_REQUEST['password']);

    // Look for the username in the database

    $stmt = $data->prepare("SELECT * FROM USER WHERE username=:username"); 
    $stmt->bindValue(':username', $username, SQLITE3_TEXT); 
    $users = $stmt->execute(); 

    $user = $users->fetchArray();

    // If user is found and if the password matches, take the user to their chore page
    // and set their session id to their id
    // If user is not found, take them to the registration page
    // If password does not match, take them back to the login page

    if (!empty($user))
    {
        if (password_verify($password, $user['password']))
        {
            $id = $user['userID'];
            $_SESSION['id'] = $id;
            header("location:chores.php?id=$id");
            die();
        } else {
            session_destroy();
            session_unset();
            header('location:login.php');
            die();
          }
    } else {
        session_destroy();
        session_unset();
        header('location:register.php');
        die();
    }
?>