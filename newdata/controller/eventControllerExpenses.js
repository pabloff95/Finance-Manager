window.addEventListener("load", function(event){
    // Control category: on click on the checkbox, disables category list selector and enables the new category
    document.getElementById("newCategory").disabled = true; // By default, new category is disabled
    this.document.getElementById("newCategoryBox").addEventListener("click", function(){
        if (this.checked){ // Checkbox checked
            document.getElementById("existingCategory").disabled = true;
            document.getElementById("newCategory").disabled = false;
        } else { // Checkbox not checked
            document.getElementById("existingCategory").disabled = false;
            document.getElementById("newCategory").disabled = true;
        }
    });
    // Start list with no-value selected
    document.getElementById("existingCategory").selectedIndex = -1;    
});