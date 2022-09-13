<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <link rel="stylesheet" href="/finances/generalStyle.css" type="text/css">
    <link rel="stylesheet" href="newdata.css" type="text/css">
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/newdata/controller/controllerExpenses.php"; // Expenses controller
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/newdata/controller/controllerIncome.php"; // Income controller
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/newdata/controller/controllerInvestment.php"; // Investment controller

    // Check if user is logged (cookies exist) and check correct user (check hash cookie)
    if (md5($_COOKIE['user'] . getSalt($_COOKIE['user'])) != $_COOKIE['hash']) {
        header("Location:/finances/index.php");
        exit();
    }
    
    // Load JS files according to form displayed (by $_GET['record'], read bellow)
    if (isset($_GET['record']) && $_GET['record'] == "expenses") {
    ?>
        <script src="controller/eventControllerExpenses.js"></script>
    <?php
    } else if (isset($_GET['record']) && $_GET['record'] == "income") {
    ?>
        <script src="controller/eventControllerIncome.js"></script>
    <?php
    } else if (isset($_GET['record']) && $_GET['record'] == "invest") {
    ?>
        <script src="controller/eventControllerInvestment.js"></script>
    <?php   } ?>

    <script>
        // Set date field default value: today
        window.addEventListener("load", function(event) {
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
    <main>
        <?php if (!isset($_GET['record'])) { ?>
            <form action="newdata.php?record=expenses" method="POST">
                <input type="submit" value="EXPENSES" class="menuButton">
            </form>
            <form action="newdata.php?record=income" method="POST">
                <input type="submit" value="INCOME" class="menuButton">
            </form>
            <form action="newdata.php?record=invest" method="POST">
                <input type="submit" value="INVESTMENT" class="menuButton">
            </form>
            <form action="/finances/menu/menu.php" method="POST">
                <input type="submit" value="MENU" class="menuButton">
            </form>
            <!-- ADD NEW RECORD FOR EXPENSES -->
        <?php } else if ($_GET['record'] == "expenses") { ?>
            <div class="title">
                <form action="newdata.php?record=invest" method="POST">
                    <input type="submit" value="<" class="change-record">
                </form>
                <h1 class="main-title">New expense</h1>
                <form action="newdata.php?record=income" method="POST">
                    <input type="submit" value=">" class="change-record">
                </form>
            </div>

            <div class="dataForm">
                <form action="newdata.php?record=expenses" method="POST">
                    <label>Expense</label><br>
                    <input type="text" name="concept" class="inputField" required ></br>

                    <label>Category</label><br>
                    <select name="dbCategory" id="existingCategory" class="inputField" required >
                        <?php printExpensesCategories(); ?>
                    </select></br>

                    <input type="checkbox" id="newCategoryBox">
                    <label>New category</label><br>
                    <input type="text" id="newCategory" name="newDBCategory" class="inputField" required ></br>

                    <label>Date</label><br>
                    <input type="date" name="date" id="date" class="inputField" required ></br>

                    <label>Amount</label><br>
                    <input type="number" name="amount" class="inputField" step=".01" required ></br>

                    <?php printConfirmationMessage(); ?>

                    <input type="submit" value="ADD" name="expensesForm" class="formButton submit-button">
                </form>
                <form action="/finances/menu/menu.php" method="POST">
                    <input type="submit" value="MENU" class="formButton">
                </form>
            </div>

            <!-- ADD NEW RECORD FOR INCOME -->
        <?php } else if ($_GET['record'] == "income") { ?>
            <div class="title">
                <form action="newdata.php?record=expenses" method="POST">
                    <input type="submit" value="<" class="change-record">
                </form>
                <h1 class="main-title">New income</h1>
                <form action="newdata.php?record=invest" method="POST">
                    <input type="submit" value=">" class="change-record">
                </form>
            </div>
            
            <div class="dataForm">                
                <form action="newdata.php?record=income" method="POST">
                    <label>Income</label><br>
                    <input type="text" name="concept" class="inputField" required ></br>

                    <label>Category</label><br>
                    <select name="dbIncomeCategory" id="existingIncomeCategory" class="inputField" required >
                        <?php printIncomeCategories(); ?>
                    </select></br>

                    <input type="checkbox" id="newIncomeCategoryBox">
                    <label>New category</label><br>
                    <input type="text" id="newIncomeCategory" name="newIncomeDBCategory" class="inputField" required ></br>

                    <label>Date</label><br>
                    <input type="date" name="date" id="date" class="inputField" required ></br>

                    <label>Amount</label><br>
                    <input type="number" name="amount" class="inputField" step=".01" required ></br>

                    <?php printConfirmationMessage(); ?>

                    <input type="submit" value="ADD" name="incomeForm" class="formButton submit-button">
                </form>
                <form action="/finances/menu/menu.php" method="POST">
                    <input type="submit" value="MENU" class="formButton">
                </form>
            </div>

        <?php } else if ($_GET['record'] == "invest") { ?>
            <div class="title">
                <form action="newdata.php?record=income" method="POST">
                    <input type="submit" value="<" class="change-record">
                </form>
                <h1 class="main-title">New investment</h1>
                <form action="newdata.php?record=expenses" method="POST">
                    <input type="submit" value=">" class="change-record">
                </form>
            </div>

            <div class="dataForm">                
                <form action="newdata.php?record=invest" method="POST">
                    <label>Category</label><br>
                    <select id="investCategory" name="categoryInvestment" class="inputField" required >
                        <option>Stock</option>
                        <option>Bond</option>
                        <option>Fund</option>
                        <option>Property</option>
                        <option>Other</option>
                    </select></br>

                    <div id="categoryFields"></div>

                    <label>Date</label><br>
                    <input type="date" id="date" name="dateInvestment" class="inputField" required ></br>

                    <label>Amount</label><br>
                    <input type="number" name="amountInvestment" class="inputField" step=".01" required ></br>

                    <?php printConfirmationMessage(); ?>

                    <input type="submit" value="ADD" name="investmentForm" class="formButton submit-button">
                </form>
                <form action="/finances/menu/menu.php" method="POST">
                    <input type="submit" value="MENU" class="formButton">
                </form>
            </div>

        <?php } ?>

    </main>
</body>

</html>