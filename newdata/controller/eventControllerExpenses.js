window.addEventListener("load", function(event){
    // Control category: on click on the checkbox, disables category list selector and enables the new category
    document.getElementById("newCategory").disabled = true; // By default, new category is disabled
    document.getElementById("newCategory").style.backgroundColor = "lightgray";
    this.document.getElementById("newCategoryBox").addEventListener("click", function(){
        if (this.checked){ // Checkbox checked
            document.getElementById("existingCategory").disabled = true;
            document.getElementById("existingCategory").style.backgroundColor = "lightgray";
            document.getElementById("newCategory").disabled = false;
            document.getElementById("newCategory").style.backgroundColor = "#EDE2F1";
        } else { // Checkbox not checked
            document.getElementById("existingCategory").disabled = false;
            document.getElementById("existingCategory").style.backgroundColor = "#EDE2F1";
            document.getElementById("newCategory").disabled = true;
            document.getElementById("newCategory").style.backgroundColor = "lightgray";
        }
    });
    // Start list with no-value selected
    document.getElementById("existingCategory").selectedIndex = -1;    
});