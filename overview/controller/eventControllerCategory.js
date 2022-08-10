window.addEventListener("DOMContentLoaded", function() {
    var dataCategoriesMonths = JSON.parse(document.getElementById("jsonCategoryDataMonths").value);
    var dataCategoriesYears = JSON.parse(document.getElementById("jsonCategoryDataYears").value);
    var category = document.getElementById("hiddenCategory").value;
    // Creat plots
    categoryPlot(dataCategoriesMonths, category, "months", "categoryChartMonths", "line");
    categoryPlot(dataCategoriesYears, category, "years", "categoryChartYears", "column");
    // Remove elements that are automatically created by the library CanvasJS
    removePlotElements();
    window.addEventListener("resize", function(){ // some elements reappear on resizing the window
        removePlotElements();
    }); 
});

// Create bar / line plots for year / monhtly data
function categoryPlot(dataCategories, category, period, id, type){
    // Define title 
    if (period == "months") {
        var title = "Monthly spent";
        var titleY = category;
    } else if (period == "years") {
        var title = "Yearly spent";
        var titleY = "";
    }
    // Create chart
    var chart = new CanvasJS.Chart(id, {
        title: {
            text: title
        },
        axisY: {
            title: titleY,
            minimum: 0
        },
        data: [{
            type: type,
            dataPoints: dataCategories
        }]
    });
    chart.render();
}

// Remove elements that are automatically created by the library CanvasJS
function removePlotElements(){
    var spam = document.getElementsByClassName("canvasjs-chart-credit");
    while(spam.length > 0){
        spam[0].parentNode.removeChild(spam[0]);
    }
}