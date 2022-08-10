window.addEventListener("DOMContentLoaded", function(event){
    // -------- GRAPHICS -------
    // Define variables with sum of total amount of income, expenses and investments (retrieved by PHP into input hidden)
    var totalIncome = document.getElementById("totalIncome").value;
    var totalExpenses = document.getElementById("totalExpenses").value;
    var totalInvestments = document.getElementById("totalInvestments").value;
    var totalSaved = totalIncome - totalExpenses - totalInvestments;
    
    // -------------- TOTAL DATA CHART --------------
    if (totalIncome != 0 || totalExpenses != 0 || totalInvestments != 0){
        // If no money was saved, show total debt with data summarized
        if (totalSaved <0) {
            detailDebt(totalIncome, totalInvestments, totalExpenses);        
        // If some money was saved display chart
        } else {
            // Get PHP array with DB data as JSON element (value stored in hidden input)
            var dataTotalDB = JSON.parse(document.getElementById("jsonTotalValues").value);
            // Create chart
            createPieChart("Finance records overview", "General overview", dataTotalDB, "chartTotalData");        
        }
    }

    // -------------- EXPENSES CHART -------------
    if (totalExpenses != 0) {
        // Get PHP array with DB data as JSON element (value stored in hidden input)
        var dataCategoryExpenses = JSON.parse(document.getElementById("jsonCategoryExpensesValues").value);
        // Create chart
        createPieChart("EXPENSES", "Total: " + totalExpenses + "€", dataCategoryExpenses, "chartCategoryExpenses");        
    }

    // -------------- INCOME CHART -------------
    if (totalIncome != 0){
        // Get PHP array with DB data as JSON element (value stored in hidden input)
        var dataCategoryIncome = JSON.parse(document.getElementById("jsonCategoryIncomeValues").value);    
        // Create chart
        createPieChart("INCOME", "Total: " + totalIncome + "€", dataCategoryIncome, "chartCategoryIncome");        
    }

    // -------------- INVESTMENT CHART -------------
    if (totalInvestments != 0) {
        // Get PHP array with DB data as JSON element (value stored in hidden input)
        var dataCategoryInvestment = JSON.parse(document.getElementById("jsonCategoryInvestmentValues").value);   
        // Create chart
        createPieChart("INVESTMENTS", "Total: " + totalInvestments + "€", dataCategoryInvestment, "chartInvestments");        
    }

});

// Create chart using CanvasJS library
function createPieChart(title, subtitle, data, container){
    // create chart
    var chart = new CanvasJS.Chart(container, {
        animationEnabled: true,
        title: {
            text: title
        },
        subtitles: [{
            text: subtitle
        }],
        // Data values, retrieved from PHP
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} {y}",
            showInLegend: true,            
            dataPoints: data
        }],
        
        toolTip:{                                
            content: "{money}"
        }       
    });
    // load chart
    chart.render();
}

// Create list element and title to detail debt (when income is lower as the sum of expenses and investments)
function detailDebt(totalIncome, totalInvestments, totalExpenses){
    // Create HTML elements
    var container = document.getElementById("chartTotalData");
    container.innerHTML = "<h1>Total debt: " + (totalIncome-totalInvestments-totalExpenses) + "€</h1>";
    var list = document.createElement("ul");
    // Gather data
    var concept = ["income", "investments", "expenses"];
    var data = [totalIncome, totalInvestments, totalExpenses];    
    // Fill container with unordered list
    data.forEach(dataElement => {
        var element = `<li>Total ${concept[data.indexOf(dataElement)]}: ${dataElement}€</li>`;
        list.innerHTML += element;
    })
    container.appendChild(list);
}

