window.addEventListener("DOMContentLoaded", function() {
    var dataCategories = JSON.parse(document.getElementById("jsonCategoryData").value);
    var category = document.getElementById("hiddenCategory").value;
    var period = document.getElementById("hiddenPeriod").value;

    categoryPlot(dataCategories, category, period);

});


function categoryPlot(dataCategories, category, period){
    // Define title 
    if (period == "months") {
        var title = "Monthly spent";
    } else if (period == "years") {
        var title = "Yearly spent";
    }
    // Create chart
    var chart = new CanvasJS.Chart("categoryChart", {
        title: {
            text: title
        },
        axisY: {
            title: category,
            minimum: 0
        },
        data: [{
            type: "line",
            dataPoints: dataCategories
        }]
    });
    chart.render();
}