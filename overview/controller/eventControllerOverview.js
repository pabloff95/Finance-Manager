window.addEventListener("DOMContentLoaded", function(){
    // Check if 1 or all (3) tables are bein displayed
    if (document.getElementById("jsonOverviewData") != null) { // 1 Table being displayed (expenses / income / investment)
        // Get data
        var chartData = JSON.parse(this.document.getElementById("jsonOverviewData").value);
        // Create plot
        overviewPlot(chartData, "overview-chart-container");

    // All tables being displayed (expenses, income, investment)
    } else {
        // Get data
        var chartDataIncome = JSON.parse(this.document.getElementById("jsonOverviewDataIncome").value);
        var chartDataExpenses = JSON.parse(this.document.getElementById("jsonOverviewDataExpenses").value);
        var chartDataInvestment = JSON.parse(this.document.getElementById("jsonOverviewDataInvestment").value);
        // Create plot
        overviewPlots(chartDataExpenses, chartDataIncome, chartDataInvestment, "overview-chart-container");
    }
    
    // Remove elements that are automatically created by the library CanvasJS (function defined in "eventController.js")
    removePlotElements();
    window.addEventListener("resize", function(){ // some elements reappear on resizing the window
        removePlotElements();
    }); 
});

// Create bar  plots for each year, representing monhtly data
function overviewPlot(data, id){
    // Create chart
    var chart = new CanvasJS.Chart(id, {
        axisY: {
            minimum: 0,
            title: "Euros (€)"
        },
        data: [{
            type: "column",
            dataPoints: data
        }],
        toolTip:{                                
            content: "{money}"
        }       
    });
    chart.render();
}

// Create bar plots for each year, representing monhtly data for each table and combine them in 1 table
function overviewPlots(dataExpenses, dataIncome, dataInvestment, id){
    // Create chart
    var chart = new CanvasJS.Chart(id, {
        axisY: {
            minimum: 0,
            title: "Euros (€)"
        },
        data: [{
            legendText: "Income",
            showInLegend: true, 
            type: "column",
            dataPoints: dataIncome
        },
        {
            legendText: "Expenses",
            showInLegend: true, 
            type: "column",
            dataPoints: dataExpenses
        },
        {
            legendText: "Investments",
            showInLegend: true, 
            type: "column",
            dataPoints: dataInvestment
        }],
        
        toolTip:{                                
            content: "{money}"
        } 
    });
    chart.render();
}













