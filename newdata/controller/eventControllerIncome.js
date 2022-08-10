window.addEventListener("load", function(event){ 
    // Control category: on click on the checkbox, disables category list selector and enables the new category
    document.getElementById("newIncomeCategory").disabled = true; // By default, new category is disabled
    this.document.getElementById("newIncomeCategoryBox").addEventListener("click", function(){
        if (this.checked){ // Checkbox checked
            document.getElementById("existingIncomeCategory").disabled = true;
            document.getElementById("newIncomeCategory").disabled = false;
        } else { // Checkbox not checked
            document.getElementById("existingIncomeCategory").disabled = false;
            document.getElementById("newIncomeCategory").disabled = true;
        }
    });

    document.getElementById("existingIncomeCategory").selectedIndex = -1;    
});