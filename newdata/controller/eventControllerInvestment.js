window.addEventListener("load", function(event){
    // Start list with no-value selected
    document.getElementById("investCategory").selectedIndex = -1;    
    // Update inputs displayed on <select> option change
    document.getElementById("investCategory").addEventListener("change", function(){
        setCategoryFields();
    });
});

// Update dynamically inputs displayed after selecting the investment type, updated in <div id="categoryFields">
function setCategoryFields(){
    var div = document.getElementById("categoryFields"); // div to append elements
    // empty div, so new appended inputs do not accumulate
    div.innerHTML = "";
    // Get selected option
    var selectTag = document.getElementById("investCategory");
    var text = selectTag.options[selectTag.selectedIndex].text;
    // Append elements according to the selected option
    switch(text){
        case "Stock":
            div.appendChild(createLabel("Company"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createInputText("companyInput", "concept"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createLabel("Share ticket"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createInputText("shareInput", "share"));
            break;
        case "Fund":
            div.appendChild(createLabel("Fund name"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createInputText("fundInput", "concept"));
            break;
        case "Bond":
            div.appendChild(createLabel("Bond origin"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createInputText("bondInput", "concept"));
            break;
        case "Property":
            div.appendChild(createLabel("Type"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createInputText("propertyInput", "concept"));
            break;
        case "Other":
            div.appendChild(createLabel("Description"));
            div.appendChild(document.createElement("br"));            
            div.appendChild(createInputText("otherInput", "concept"));
            break;
    }
}

// Create HTML element to be appended: <label>
function createLabel(text){
    var label = document.createElement("label");
    label.innerText = text;
    return label;
}

// Create HTML element to be appended: <input type="text">
function createInputText(id, name){
    var input = document.createElement("input");
    input.type = "text";
    input.id = id;
    input.className = "inputField";
    input.setAttribute("name", name);
    return input;
}