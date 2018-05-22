// Footer Dates (Day of week and year)
var d = new Date();
var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
var year = d.getFullYear();

// Welcome Date
document.getElementById("date").innerHTML = months[d.getMonth()] + ' ' + d.getDate() + ', ' + year;

// Footer Date
document.getElementById("foot-date").innerHTML = year;
