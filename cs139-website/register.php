<!-- This page lets the user register for a new account -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Register</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/register.js"></script>
  </head>
  <body id="greenbg">
    <div class="center">
      <div class="box">
        <h1 id="header">DO.</h1>

        <!-- Form for registration, message boxes for error messages -->
        <div class="form-box">
          <form id='form' method='post' action="newUser.php">

            <!-- User email -->
            <p>
              <label for="email"><b>Email: </b></label>
              <input type ="text" name="user_email" id="email" placeholder="Your email...">
            </p>
            <div id="message1">
            </div>

            <!-- Username -->
            <p>
              <label for="username"><b>Username: </b></label>
              <input type ="text" name="username" id="username" placeholder="Your username...">
            </p>
            <div id="message2">
            </div>

            <!-- Password -->
            <p>
              <label for="password"><b>Password: </b></label>
              <input type="password" name="password" id="password" placeholder="Your password...">
            </p>
            <div id="message3">
            </div>

            <!-- Password check -->
            <p>
              <label for="check_password"><b>Re-enter Password: </b></label>
              <input type="password" name="check_password" id="check_password" placeholder="Re-enter your password...">
            </p>
            <div id="message4">
            </div>
            
            <input type="submit" value="Register">
          </form>
        </div>
      </div>

    </div>
  </body>
</html>
