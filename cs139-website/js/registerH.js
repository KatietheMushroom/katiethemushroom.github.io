// This validates the format for user input on the household registration page
// If the user clicks submit when their details do not fulfil the criteria, it displays
// where there are issues and stops the form from submitting

$(document).ready( function() {

    // Obtain values from the form 
    var name = document.getElementById("name");
    var password = document.getElementById("password");
    var check_password = document.getElementById("check_password");
    var valid = true;

    $("#form").submit(function() {

        // Clear error messages at start, set valid to default value
        $("#message1").html("");
        $("#message2").html("");
        $("#message3").html("");
        valid = true;
        
        if (name.value == null || name.value == "") {
            valid = false;
            $("#message1").append("<p>House name cannot be empty!</p>");
        }

        if (password.value == null || password.value == "") {
            valid = false;
            $("#message2").append("<p>Password cannot be empty!</p>");
        }

        if (check_password.value == null || check_password.value == "") {
            valid = false;
            $("#message3").append("<p>Password check cannot be empty!</p>");
        }

        if (password.value.length < 8) {
            valid = false;
            $("#message2").append("<p>Password must be longer than 7 characters!</p>");
        } 

        if (password.value != check_password.value) {
            valid = false;
            $("#message3").append("<p>Passwords do not match!</p>");
        } 
        
        // The database will not be updated if valid is false
        return valid;
    });
});