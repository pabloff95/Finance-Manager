window.addEventListener("load", function(event){
    // Import data from excel into DB
    document.getElementById("importSubmit").addEventListener("click", function(){
        // Wait until excel file is loaded and then submits the form to insert the data in the DB (via PHP)
        loadFile().then(function(){
            document.getElementById("importForm").submit();
        });
    });
});

// Function to load a file. The function execution finishes when a excel file has been loaded
function loadFile(){
    return new Promise(function (resolve) {
        // Click on input type="file"
        document.getElementById("fileInput").click();
        // wait until .xlsx file is loaded, then returns true
        var wait = waitFileLoaded().then(function() {
            resolve(true);
        }); 
    });
}

// Function to check if .xlsx document was loaded by using the file input
async function waitFileLoaded(){
    var file = document.getElementById("fileInput").value; // input value
    // check content of input
    if (file.includes(".xlsx")){ // when excel file is loaded
        return true;
    } else { // while excel file is not loaded: waits 500 miliseconds and calls again the function (recursion)
        await new Promise(resolve => setTimeout(resolve, 500)); // waits 500 ms
        return waitFileLoaded(); // Calls again the function to check if condition now is accomplished
    }
}

