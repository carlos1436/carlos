function displayCurrentDateTime() {
    var today = new Date();

    // Display date
    var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
    var formattedDate = today.toLocaleDateString(undefined, options);
    document.getElementById("currentDate").innerHTML = formattedDate;

    // Display time
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var seconds = today.getSeconds();
    var amPm = "am";
    if (hours > 12) {
        amPm = "pm";
        hours = hours - 12;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }

    var time = hours + ' : ' + minutes + ' : ' + seconds + ' ' + amPm;
    document.getElementById("currentTime").innerHTML = time;

    setTimeout(displayCurrentDateTime, 1000);
}

// Call the function when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    displayCurrentDateTime();
});
