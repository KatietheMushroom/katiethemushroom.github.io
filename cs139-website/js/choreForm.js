// This displays the custom interval field, when the option 'Every x days' is selected in the 
// frequency field

$(document).ready(function() { 

    // When 'Custom' (Every x days) is selected, display the interval field
    // When anything else is selected, remove the interval field
    $('#frequency').on('change', function (event) {
        var selected = this.value;
        console.log(selected);
        if (selected == 'Custom') {
            console.log("Selected", selected);
            document.getElementById('interval-label').style.display = 'inline-block';
            document.getElementById('interval').style.display = 'inline-block';
        }
        else {
            document.getElementById('interval-label').style.display = 'none';
            document.getElementById('interval').style.display = 'none';
        }
    });

 });
