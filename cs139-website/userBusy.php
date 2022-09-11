<?php

  // This function looks through the user table and determines which user is the least busy

  $data = new Database();

  function leastBusy($householdID) {

    global $data; 
    $smallest = 100000;

    // Get all users from the user's household 
    $stmt = $data->prepare("SELECT * FROM USER WHERE householdID=:householdID"); 
    $stmt->bindValue(':householdID', $householdID, SQLITE3_INTEGER); 
    $users = $stmt->execute(); 
    
    // Loop through all users
    while ($user = $users->fetchArray()) {

        // Get all chores allocated to the user 
        $stmt = $data->prepare("SELECT SUM(weight) FROM CHORE WHERE userID=:userID"); 
        $stmt->bindValue(':userID', $user['userID'], SQLITE3_INTEGER); 
        $sum = $stmt->execute(); 
        $sum = $sum->fetchArray();
        $sum = array_pop($sum);


        // If the sum of the weight of a user's chores is lower than the last,
        // select that user's id and change smallest to its weight sum
        if ($sum < $smallest) {
            $smallest = $sum;
            $victimID = $user['userID'];
        }
    }

    return $victimID;
    
  }

?>
