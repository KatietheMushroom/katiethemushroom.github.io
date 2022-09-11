<!-- This page contains the login form, which sends its information to authenticate.php -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>DO. - Login</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery-3.5.1.min.js"></script>
  </head>
  <body id="greenbg">
    <div class="center">
        <div class="box">
        <h1 id="header">DO.</h1>

        <!-- Form for the user to log in -->
        <div class="form-box">
          <form id='form' method='post' action="authenticate.php">

              <!-- Username -->
              <p>
                <label for="username"><b>Username: </b></label>
                <input type ="text" name="username" id="username" placeholder="Your username...">
              </p>

              <!-- Password -->
              <p>
                <label for="password"><b>Password: </b></label>
                <input type="password" name="password" id="password" placeholder="Your password...">
              </p>

              <input type="submit" value="Login">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
