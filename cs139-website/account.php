<?php

  // Page that displays the user's account information, such as:
  // Name, date joined, household etc. They can also change nickname and icon here
  // User has to be logged in to access this page

  session_start();

  require 'access.php';
  requireLogIn();  

  $userID = $_SESSION['id'];

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Your Account</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
  </head>
  <body>
    <div class="wrap">
      <h1>DO.</h1>

      <!-- Top nav bar and side bar of summary of some user info -->
      <?php include_once 'menu.php' ?>
      <?php include_once 'summary.php' ?>
      <div class="content">

        <!-- Main Content: User's account information -->
        <h2>Your Account</h2> 
        <hr><br/>

        <div class="info">
        <?php

          // Retrieve the user's information from database
          
          $data = new Database();

          $stmt = $data->prepare("SELECT * FROM USER WHERE userID=:userID"); 
          $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER); 
          $users = $stmt->execute(); 

          $user = $users->fetchArray();

          $nickname = $user['nickname'];
          $username = $user['username'];
          $email = $user['email'];
          $dateJoined = $user['dateJoined'];
          $householdID = $user['householdID'];

          // Display the relevant information. If the user is not in a household, display 'None'

          $html = "<p><b>Username: </b>".$username."</p><p><b>Email: </b>".$email."</p><p><b>Date Joined: </b>".$dateJoined."</p><p><b>Household: </b>";

          if (isset($householdID)) {
            $stmt = $data->prepare("SELECT * FROM HOUSEHOLD WHERE householdID=:householdID"); 
            $stmt->bindValue(':householdID', $householdID, SQLITE3_INTEGER); 
            $household = $stmt->execute(); 

            $house = $household->fetchArray();

            $html.=$house['name']."</p>";
          } else {
            $html.="None</p>";
          }

          echo $html;
        ?>

        <!-- User can update their nickname here -->

        <div class="form-box">
          <form action="updateAccount.php" method="post" accept-charset="utf-8">
              <label for="nickname"><b>Nickname: </b></label>
              <input type="text" id="nickname" name="nickname" value="<?php echo $nickname?>">
              <input type="submit" value="Update">
          </form>
        </div>

        <!-- User can select their icon here -->

        <?php
          echo "<p><b>Choose an icon: </b></p>";
          for ($x = 1; $x < 10; $x++) {
            echo "<div class='iconSelect'><a href='https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/updateIcon.php?id=".$x."'><div class='iconSelect'><img src='img/".$x.".jpg' alt='icon ".$x."'></div></div>";
          }
        ?>

        </div>
        <hr><br/>
      </div>
    </div>
  </body>
</html>
