window.addEventListener("load", function(event){
    // Disable share input if other category than "Stock" is selected
    var categoryInput = document.getElementById("categorySelected");
    // Check if share input exists --> pressed on edit record 
    if (document.body.contains(categoryInput)){
        // Save share input value
        const shareOriginalText = document.getElementById('shareField').value;    
        // if not Stock selected disable share field from begining on
        if (categoryInput.options[categoryInput.selectedIndex].text != "Stock") { 
            document.getElementById('shareField').disabled = true;
        }
        // add event on changing category
        categoryInput.addEventListener("change", function(){
            var selectedCategory = categoryInput.options[categoryInput.selectedIndex].text; // Category selected <option>
            if (selectedCategory != "Stock") { // if not Stock selected disable share field and clean value
                document.getElementById('shareField').disabled = true;
                document.getElementById('shareField').value = "";
            } else { // if stock category is selected, enable and restore original value
                document.getElementById('shareField').disabled = false;
                document.getElementById('shareField').value = shareOriginalText;
            }
        });        
    }
});


