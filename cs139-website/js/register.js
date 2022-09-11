// This validates the format for user input on the user registration page
// If the user clicks submit when their details do not fulfil the criteria, it displays
// where there are issues and stops the form from submitting

$(document).ready( function() {

    // Obtain values from the form
    var email = document.getElementById("email");
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var check_password = document.getElementById("check_password");
    var valid = true;

    $("#form").submit(function() {

        // Clear error messages at start, set valid to default value
        $("#message1").html("");
        $("#message2").html("");
        $("#message3").html("");
        $("#message4").html("");
        valid = true;

        // This is pretty self-explanatory 
        if (email.value == null || email.value == "") {
            valid = false;
            $("#message1").append("<p>Email cannot be empty!</p>");
        }
        
        if (username.value == null || username.value == "") {
            valid = false;
            $("#message2").append("<p>Username cannot be empty!</p>");
        }

        if (password.value == null || password.value == "") {
            valid = false;
            $("#message3").append("<p>Password cannot be empty!</p>");
        }

        if (check_password.value == null || check_password.value == "") {
            valid = false;
            $("#message4").append("<p>Password check cannot be empty!</p>");
        }

        if (password.value.length < 8) {
            valid = false;
            $("#message3").append("<p>Password must be longer than 7 characters!</p>");
        } 

        if (password.value != check_password.value) {
            valid = false;
            $("#message4").append("<p>Passwords do not match!</p>");
        } 
        
        // The database will not be updated if valid is false
        return valid;
    });
});