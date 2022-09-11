<?php

    include_once 'database.php';
    $data = new Database();

    // If session id is not set, user is not logged in: redirect to login page
    function requireLogIn() {
        if (!isset($_SESSION['id'])) {
            header('location:login.php');
            die();
          }
    }

    // If user hasn't joined a house yet, redirect to the join household page
    function requireHouse() {
        global $data;
        $id = $_SESSION['id'];
        $user = $data->querySingle("SELECT * FROM USER WHERE userID=$id");
        if (!isset($user['householdID'])) {
            header("location:joinHousehold.php");
            die();
        }
    }

?>