<?php

  // This function changes the status of chores based on the date today, and is 
  // called when chores need to be displayed. It also deals with overdue chores

  $data = new Database();

  function update($householdID) {

    global $data; 

    // Get today's date
    $today = new DateTime(date("Y-m-d"));

    // Get all chores from the user's household 
    $stmt = $data->prepare("SELECT * FROM CHORE WHERE householdID=:householdID"); 
    $stmt->bindValue(':householdID', $householdID, SQLITE3_INTEGER); 
    $chores = $stmt->execute(); 

    // Loop through all chores
    while ($chore = $chores->fetchArray()) {

        // Get chore ID, date due and find the difference between date due and today
        $choreID = $chore['choreID'];
        $dateDue = new DateTime($chore['dateDue']);
        $interval = (int) $today->diff($dateDue)->format("%r%a");

        // This means due date was before today
        if ($interval < 0) {

            // One-time chore that is completed: remove it entirely
            if ($chore['frequency'] == 'Once' && $chore['status'] == 'Complete') {

                $data->exec("DELETE FROM CHORE WHERE choreID=$choreID");
            } 

            // One-time chore that is incomplete: change status to 'Overdue'
            else if ($chore['frequency'] == 'Once') {

                $stmt = $data->prepare("UPDATE CHORE SET status=:status WHERE choreID=:choreID"); 
                $stmt->bindValue(':choreID', $choreID, SQLITE3_INTEGER); 
                $stmt->bindValue(':status', 'Overdue', SQLITE3_TEXT);
                $stmt->execute();
            } 

            // Repeating chore that is completed: change due date to the next one
            else if ($chore['status'] == 'Complete') {

                $dateDue->modify('+ '.$chore['interval'].' day');
                $due = $dateDue->format('Y-m-d');

                $stmt = $data->prepare("UPDATE CHORE SET dateDue=:dateDue, status=:status WHERE choreID=:choreID"); 
                $stmt->bindValue(':choreID', $choreID, SQLITE3_INTEGER); 
                $stmt->bindValue(':dateDue', $due, SQLITE3_TEXT);
                $stmt->bindValue(':status', 'Incomplete', SQLITE3_TEXT);
                $stmt->execute();
            } 

            // Repeating chore that is incomplete: change status to 'Overdue'
            // Also make a copy of it due the nearest date after today
            else if ($chore['status'] != 'Overdue') {

                $stmt = $data->prepare("UPDATE CHORE SET status=:status WHERE choreID=:choreID"); 
                $stmt->bindValue(':choreID', $choreID, SQLITE3_INTEGER); 
                $stmt->bindValue(':status', 'Overdue', SQLITE3_TEXT);
                $stmt->execute();

                $due = $chore['dateDue'];
                while ($due < date("Y-m-d")) {
                    $dateDue->modify('+ '.$chore['interval'].' day');
                    $due = $dateDue->format('Y-m-d');
                }

                $stmt = $data->prepare("INSERT INTO CHORE (householdID, userID, creatorID, task, note, dateAdded, status, frequency, interval, starting, dateDue, weight) 
                VALUES (:householdID, :userID, :creatorID, :task, :note, :today, :status, :frequency, :interval, :starting, :dateDue, :weight)");
                $stmt->bindValue(':householdID', $chore['householdID'], SQLITE3_INTEGER); 
                $stmt->bindValue(':userID', $chore['userID'], SQLITE3_INTEGER); 
                $stmt->bindValue(':creatorID', $chore['creatorID'], SQLITE3_INTEGER); 
                $stmt->bindValue(':task', $chore['task'], SQLITE3_TEXT); 
                $stmt->bindValue(':note', $chore['note'], SQLITE3_TEXT); 
                $stmt->bindValue(':today', $chore['dateAdded'], SQLITE3_TEXT); 
                $stmt->bindValue(':status', 'Incomplete', SQLITE3_TEXT); 
                $stmt->bindValue(':frequency', $chore['frequency'], SQLITE3_TEXT); 
                $stmt->bindValue(':interval', $chore['interval'], SQLITE3_INTEGER); 
                $stmt->bindValue(':starting', $chore['starting'], SQLITE3_TEXT); 
                $stmt->bindValue(':dateDue', $due, SQLITE3_TEXT); 
                $stmt->bindValue(':weight', $chore['weight'], SQLITE3_INTEGER); 
                $stmt->execute();
            }
        } 
    }
  }

?>
