<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <script src="controller/eventController.js"></script>

    <?php if (!isset($_GET['category'])) { ?>
        <script src="controller/eventControllerTime.js"></script>
    <?php } else if (isset($_GET['category'])) { ?>
        <script src="controller/eventControllerCategory.js"></script>
    <?php } ?>

    <?php require_once "controller/dbControllerTime.php"; ?>
    <?php require_once "controller/dbControllerCategory.php"; ?>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <link rel="stylesheet" href="../generalStyle.css" type="text/css">
    <link rel="stylesheet" href="overview.css" type="text/css">

</head>

<body>
    <header>
        <div id="header-container">            
            <div class="header-section">
                <form action="/finances/index.php" method="POST">
                    <input type="submit" value="MENU" class="header-button">
                </form>
            </div>
            <div class="header-section">
                <h1>FINANCE HISTORY</h1>
            </div>
            <div class="header-section">
                <?php if (isset($_GET['time']) || isset($_GET['category'])) { ?>
                    <form action="overview.php" method="POST">
                        <input type="submit" value="RESET" class="header-button">
                    </form></br>
                <?php } ?>
            </div>
        </div>
        <?php hiddenCategories();
        if (!isset($_GET['category'])) { ?>
            <input type="hidden" id="totalIncome" value="<?php echo getTotalAmount("income"); ?>">
            <input type="hidden" id="totalExpenses" value="<?php echo getTotalAmount("expenses"); ?>">
            <input type="hidden" id="totalInvestments" value="<?php echo getTotalAmount("investment"); ?>">
            <!-- Used to send PHP array with data to JS script -->
            <input type="hidden" id="jsonTotalValues" value='<?php echo json_encode(arrayTotalValues(), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryExpensesValues" value='<?php echo json_encode(arrayExpenses(), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryIncomeValues" value='<?php echo json_encode(arrayIncome(), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryInvestmentValues" value='<?php echo json_encode(arrayInvestment(), JSON_NUMERIC_CHECK); ?>'>
        <?php }

        if (isset($_GET['category'])) { ?>
            <input type="hidden" id="jsonCategoryDataMonths" value='<?php echo json_encode(categoryDataArray($_POST['selectedCategory'], $_GET['category'], "months"), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryDataYears" value='<?php echo json_encode(categoryDataArray($_POST['selectedCategory'], $_GET['category'], "years"), JSON_NUMERIC_CHECK); ?>'>

            <input type="hidden" id="hiddenCategory" value='<?php echo $_POST['selectedCategory']; ?>'>
        <?php } ?>


    </header>

    <aside>
        <form action="overview.php?time=period" method="POST" class="search-form">
            <h3>Specific period</h3>
            <label>From</label>
            <input type="date" name="fromDate" class="inputField" required><br>

            <label>To</label>
            <input type="date" name="toDate" id="toDate" class="inputField" required><br>

            <input type="submit" value="SHOW" class="search-button">
        </form><br>

        <form action="overview.php?time=month" method="post" class="search-form">
            <h3>Month & Year</h3>
            <select class="monthSelector inputField" id="selectedMonth" name="selectedMonth" required></select><br>
            <select class="yearSelector inputField" id="selectedYear" name="selectedYear" required></select><br>
            <input type="submit" value="SHOW" class="search-button">
        </form><br>

        <form action="overview.php?time=year" method="post" class="search-form">
            <h3>Year</h3>
            <select class="yearSelector inputField" id="displayYear" name="displayYear" required></select><br>
            <input type="submit" value="SHOW" class="search-button">
        </form><br>

        <form action="" method="post" id="categoryForm" class="search-form"> <!-- action controlled from JS -->
            <h3>Category search</h3>
            <label for="financeTypeSelector">Finance type</label>
            <select name="financeType" id="financeTypeSelector" class="inputField" required>
                <option selected disabled></option>
                <option value="1">Expenses</option>
                <option value="2">Investments</option>
                <option value="3">Income</option>
            </select><br>
            <div id="selectCategoryDiv">
                <label for="financeCategorySelector">Category</label>
                <select name="selectedCategory" id="financeCategorySelector" class="inputField" required></select><br>
            </div>
            <input type="submit" value="SHOW" class="search-button">
        </form>

    </aside>

    <main>
        <?php if (!isset($_GET['category'])) { ?>
            <div class="chart-container">
                <div class="title-container"><p class="chart-title">GENERAL OVERVIEW</p></div>
                <div id="chartTotalData" class="chart"></div>
            </div>
            <div class="chart-container">
                <div class="title-container"><p class="chart-title">INVESTMENTS</p></div>
                <div id="chartInvestments" class="chart"></div>
            </div>
            <div class="chart-container">
                <div class="title-container"><p class="chart-title">EXPENSES</p></div>
                <div id="chartCategoryExpenses" class="chart"></div>
            </div>
            <div class="chart-container">
                <div class="title-container"><p class="chart-title">INCOME</p></div>
                <div id="chartCategoryIncome" class="chart"></div>
            </div>

        <?php } else if (isset($_GET['category'])) { ?>
            <div class="chart-container category">
                <div class="title-container"><p class="chart-title">MONTHLY SPENT</p></div>
                <div id="categoryChartMonths" class="chart"></div>
            </div>
            <div class="chart-container category">
                <div class="title-container"><p class="chart-title">YEARLY SPENT</p></div>
                <div id="categoryChartYears" class="chart"></div>
            </div>          
        <?php } ?>

    </main>

</body>

</html>