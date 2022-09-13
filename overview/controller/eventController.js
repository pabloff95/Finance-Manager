window.addEventListener("DOMContentLoaded", function(event){
    // Add <option> elements to <select> for years and months
    monthElement();
    yearElement();
    // Set dates <select> elements to current dates
    document.getElementById('toDate').valueAsDate = new Date();
    document.getElementById('selectedMonth').value = currentMonth();
    document.getElementById('selectedYear').value = new Date().getFullYear();
    document.getElementById('displayYear').value = new Date().getFullYear();    
    // Add event on changing finance type selector, to show the categories available for that finance element and change form action attribute
    var selectElementDiv = document.getElementById("selectCategoryDiv");
    selectElementDiv.style.display = "none";
    document.getElementById("financeTypeSelector").addEventListener("change", function(){
        selectElementDiv.style.display = "block";
        let form = document.getElementById("categoryForm");
        // If expenses selected
        if (this.value == 1) { 
            fillSelectCategory("expensesCategories"); 
            form.action = "overview.php?category=expenses";
        // If investments selected
        } else if (this.value == 2) {
            fillSelectCategory("investmentCategories");    
            form.action = "overview.php?category=investment";        
        // If income selected
        } else if (this.value == 3) {
            fillSelectCategory("incomeCategories");        
            form.action = "overview.php?category=income";    
        }
    });

    // Allow only one <details> to be oppened at the time
    document.querySelectorAll('details').forEach((detail, index , allDetails)=>{
        detail.ontoggle = () =>{ // ontoggle event: "execute a JavaScript when a <details> element is opened or closed"
             if(detail.open) {
                // Close all details tags that are different to the current selected
                allDetails.forEach(detailElement =>{
                    if(detailElement != detail) {
                        detailElement.open=false 
                    }
                })
             } 
        }
    });
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

// Fill category selector element to fill it with the categories in DB (creating <option> elements)
function fillSelectCategory(id) {
    // Get selector and "reset" it
    let categorySelector = document.getElementById("financeCategorySelector");
    categorySelector.innerHTML = "";
    let emptyStart = document.createElement("option");    
    emptyStart.disabled = true;
    emptyStart.selected = true;
    categorySelector.appendChild(emptyStart);
    // Get category data into array
    let data = document.getElementById(id).value;
    data = data.split("/");
    data.pop(); // Deletes empty element at end
    // Create <option> elements and append them to <select>
    data.forEach(category => {
        let option = document.createElement("option");    
        option.innerHTML = category;
        categorySelector.appendChild(option);
    });  
}

// Remove elements that are automatically created by the library CanvasJS
function removePlotElements(){
    var spam = document.getElementsByClassName("canvasjs-chart-credit");
    while(spam.length > 0){
        spam[0].parentNode.removeChild(spam[0]);
    }
}












