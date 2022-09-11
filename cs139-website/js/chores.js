// This updates chore.php when the user completes tasks, switch views or click into tasks

$(document).ready(function() { 

    // Display the user's current active chores by default 
    $.get("activeChores.php", function(html) {document.getElementById("chores").innerHTML = html});
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
    // Remove active tag from bottom tab for correct display
    $("#tabA").click(function () {
        $.get("activeChores.php", function(html) {document.getElementById("chores").innerHTML = html})
        this.classList.add("active");
        document.getElementById("tabB").classList.remove("active");
    });

    // When the bottom tab is clicked, mark it as active and retrieve the list of upcoming tasks
    // Remove active tag from top tab for correct display
    $("#tabB").click(function () {
        $.get("upcomingChores.php", function(html) {document.getElementById("chores").innerHTML = html})
        this.classList.add("active");
        document.getElementById("tabA").classList.remove("active");
    });

 });
