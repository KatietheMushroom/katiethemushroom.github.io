// This updates household.php when the user completes tasks, switch views or click into tasks

$(document).ready(function() { 

    // Display household's current active chores by default 
    $.get("houseActiveChores.php", function(html) {document.getElementById("chores").innerHTML = html});
    document.getElementById("tabA").classList.add("active");

    // When the complete button is clicked, update the status of the corresponding chore
    // Remove the row from display, as the task is done
    $('#chores').on('click', 'button', function(event) {
        event.stopPropagation();
        console.log("Clicked", this);
        var choreID = this.id;
        $.post("taskDone.php", {"id" : choreID}, ($(this).closest("tr").remove()));
    });

    // When a row is clicked, navigate to the chore details page
    $('#chores').on('click', 'table tr', function() {
        console.log("Clicked", this);
        var choreID = this.id;
        window.location.href = "https://cs139.dcs.warwick.ac.uk/~u2002344/cs139/do/chore.php?id="+this.id;
    });

    // When the top tab is clicked, mark it as active and retrieve the list of active tasks
    // Remove active tag from other tabs for correct display
    // If the add task button is not displayed, display it. Also make text align left
    $("#tabA").click(function () {
        $.get("houseActiveChores.php", function(html) {document.getElementById("chores").innerHTML = html})
        this.classList.add("active");
        if (document.getElementById("tabB").classList.contains("active")) document.getElementById("tabB").classList.remove("active");
        else document.getElementById("tabC").classList.remove("active");
        document.getElementById("add-task").style.display = "block";
        document.getElementById("chores").style.textAlign = "left";
    });

    // When the middle tab is clicked, mark it as active and retrieve the list of upcoming tasks
    // Remove active tag from other tabs for correct display
    // If the add task button is not displayed, display it. Also make text align left
    $("#tabB").click(function () {
        $.get("houseUpcomingChores.php", function(html) {document.getElementById("chores").innerHTML = html})
        this.classList.add("active");
        if (document.getElementById("tabA").classList.contains("active")) document.getElementById("tabA").classList.remove("active");
        else document.getElementById("tabC").classList.remove("active");
        document.getElementById("add-task").style.display = "block";
        document.getElementById("chores").style.textAlign = "left";
    });

    // When the bottom tab is clicked, mark it as active and retrieve the list of household members
    // Remove active tag from other tabs for correct display
    // If the add task button is displayed, remove it. Also make the members float in center
    $("#tabC").click(function () {
        $.get("members.php", function(html) {document.getElementById("chores").innerHTML = html})
        this.classList.add("active");
        if (document.getElementById("tabA").classList.contains("active")) document.getElementById("tabA").classList.remove("active");
        else document.getElementById("tabB").classList.remove("active");
        document.getElementById("add-task").style.display = "none";
        document.getElementById("chores").style.textAlign = "center";
    });

 });
