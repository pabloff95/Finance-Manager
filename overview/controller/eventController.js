window.addEventListener("DOMContentLoaded", function(event){
    // Add <option> elements to <select> for years and months
    monthElement();
    yearElement();
    // Set dates <select> elements to current dates
    document.getElementById('toDate').valueAsDate = new Date();
    document.getElementById('selectedMonth').value = currentMonth();
    document.getElementById('selectedYear').value = new Date().getFullYear();
    document.getElementById('displayYear').value = new Date().getFullYear();    

});

// Function to fill <select> tag with a month list
function monthElement(){
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    // Get select elements to contain months by class name -> transform to array to iterate in next steps
    var selectElement = Array.from(document.getElementsByClassName("monthSelector"));
    // Fill all select elements with the month array list
    months.forEach(month =>{        
        selectElement.forEach(select => {            
            const node = document.createElement("option");
            node.appendChild(document.createTextNode(month));
            select.appendChild(node);
            select.selectedIndex = -1; // Default value blank
        });
    });
}

// Get current month
function currentMonth(){
    const month = new Date().getMonth();    
    let monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    let currentMonth = monthsList[month];
    return currentMonth;
}


// Function to fill <select> tag with a year list
function yearElement(){
    // Create array of years until current year (from 2000)
    var years = [];
    const currentYear = new Date().getFullYear();
    for (var i = currentYear; i > 1999; i-- ){
        years.push(i);        
    }
    // Fill <select> elements with <option> elements with the year list created
    var selectElement = Array.from(document.getElementsByClassName("yearSelector"));
    // Fill all select elements with the year array list
    years.forEach(year =>{
        selectElement.forEach(select => {            
            const node = document.createElement("option");
            node.appendChild(document.createTextNode(year));
            select.appendChild(node);
            select.selectedIndex = -1; // Default value blank
        });
    });
}















