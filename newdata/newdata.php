<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <?php 
        require $_SERVER['DOCUMENT_ROOT'] . "/finances/newdata/controller/controllerExpenses.php"; // Expenses controller
        require $_SERVER['DOCUMENT_ROOT'] . "/finances/newdata/controller/controllerIncome.php"; // Income controller
        require $_SERVER['DOCUMENT_ROOT'] . "/finances/newdata/controller/controllerInvestment.php"; // Investment controller

        // Load JS files according to form displayed (by $_GET['record'], read bellow)
        if (isset($_GET['record']) && $_GET['record'] == "expenses") {
    ?>
            <script src="controller/eventControllerExpenses.js" ></script>
    <?php
        } else if (isset($_GET['record']) && $_GET['record'] == "income") {
    ?>
            <script src="controller/eventControllerIncome.js" ></script>
    <?php
        } else if (isset($_GET['record']) && $_GET['record'] == "invest") {
    ?>
            <script src="controller/eventControllerInvestment.js" ></script>
    <?php   } ?>       

    <script>
        // Set date field default value: today
        window.addEventListener("load", function(event){
            document.getElementById('date').valueAsDate = new Date();
        });
    </script>
</head>
<body>
    <!-- SCREEN CONTROLLED BY $_GET['record']:
        - When not existing -> displays normal menu to chose data to record
        - When setted to expenses -> displays add expense menu
        - When setted to income -> displays add income menu
    -->
    
    <!-- SELECT RECORD TO BE ADDED SCREEN --> 
    <?php if (!isset($_GET['record'])) { ?>
        <form action="newdata.php?record=expenses" method="POST">
            <input type="submit" value="EXPENSES">
        </form>
        <form action="newdata.php?record=income" method="POST">
            <input type="submit" value="INCOME">
        </form>
        <form action="newdata.php?record=invest" method="POST">
            <input type="submit" value="INVESTMENT">
        </form>

    <!-- ADD NEW RECORD FOR EXPENSES --> 
    <?php } else if ($_GET['record'] == "expenses"){ ?>
        <form action="newdata.php?record=expenses" method="POST">
            <label>Expense</label>
            <input type="text" name="concept"></br>

            <label>Category</label>
            <select name="dbCategory" id="existingCategory">            
                <?php printExpensesCategories(); ?>            
            </select></br>

            <input type="checkbox" id="newCategoryBox">
            <label>New category</label>
            <input type="text" id="newCategory" name="newDBCategory"></br>

            <label>Date</label>
            <input type="date" name="date" id="date"></br>

            <label>Amount</label>
            <input type="number" name="amount"></br>

            <?php printExpensesConfirmationMessage(); ?>

            <input type="submit" value="ADD" name="expensesForm">        
        </form>

    <!-- ADD NEW RECORD FOR INCOME --> 
    <?php } else if ($_GET['record'] == "income"){ ?>
        <form action="newdata.php?record=income" method="POST">
            <label>Income</label>
            <input type="text" name="concept"></br>

            <label>Category</label>
            <select name="dbIncomeCategory" id="existingIncomeCategory">            
                  <?php printIncomeCategories(); ?>      
            </select></br>

            <input type="checkbox" id="newIncomeCategoryBox">
            <label>New category</label>
            <input type="text" id="newIncomeCategory" name="newIncomeDBCategory"></br>

            <label>Date</label>
            <input type="date" name="date" id="date"></br>

            <label>Amount</label>
            <input type="number" name="amount"></br>

            <?php printIncomeConfirmationMessage(); ?>

            <input type="submit" value="ADD" name="incomeForm">        
        </form>
    
    <?php } else if ($_GET['record'] == "invest"){ ?>
        <form action="newdata.php?record=invest" method="POST">

            <label>Category</label>
            <select id="investCategory" name="categoryInvestment">            
                <option>Stock</option>
                <option>Bond</option>
                <option>Fund</option>
                <option>Property</option>
                <option>Other</option>
            </select></br>

            <div id="categoryFields"></div>

            <label>Date</label>
            <input type="date" id="date" name="dateInvestment"></br>

            <label>Amount</label>
            <input type="number" name="amountInvestment"></br>

            <?php printConfirmationInvestment(); ?>

            <input type="submit" value="ADD" name="investmentForm">        
    </form>
    <?php } ?>    

    <!-- BACK TO MENU (shared by all other menus)--> 
    <form action="/finances/index.php" method="POST">
        <input type="submit" value="MENU">
    </form>

</body>
</html>