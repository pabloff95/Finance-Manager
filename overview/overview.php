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

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="overview.css" type="text/css">
    <?php require_once "controller/dbControllerTime.php"; ?>
    <?php require_once "controller/dbControllerCategory.php"; ?>
</head>

<body>
    <header>
        <h1>FINANCE HISTORY</h1>
        <?php if (!isset($_GET['category'])) { ?>
            <input type="hidden" id="totalIncome" value="<?php echo getTotalAmount("income"); ?>">
            <input type="hidden" id="totalExpenses" value="<?php echo getTotalAmount("expenses"); ?>">
            <input type="hidden" id="totalInvestments" value="<?php echo getTotalAmount("investment"); ?>">
            <!-- Used to send PHP array with data to JS script -->
            <input type="hidden" id="jsonTotalValues" value='<?php echo json_encode(arrayTotalValues(), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryExpensesValues" value='<?php echo json_encode(arrayExpenses(), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryIncomeValues" value='<?php echo json_encode(arrayIncome(), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryInvestmentValues" value='<?php echo json_encode(arrayInvestment(), JSON_NUMERIC_CHECK); ?>'>
        <?php } ?>

        <?php if (isset($_GET['category'])) { ?>
            <input type="hidden" id="jsonCategoryDataMonths" value='<?php echo json_encode(categoryDataArray($_POST['selectedCategory'], $_GET['category'], "months"), JSON_NUMERIC_CHECK); ?>'>
            <input type="hidden" id="jsonCategoryDataYears" value='<?php echo json_encode(categoryDataArray($_POST['selectedCategory'], $_GET['category'], "years"), JSON_NUMERIC_CHECK); ?>'>
            
            <input type="hidden" id="hiddenCategory" value='<?php echo $_POST['selectedCategory']; ?>'>
            <input type="hidden" id="hiddenPeriod" value='<?php echo $_POST['period']; ?>'>
        <?php } ?>

    </header>

    <aside>
        <details>
            <summary>Filter data by period of time</summary>
            <form action="overview.php?time=period" method="POST">
                <h3>Specific period</h3>
                <label>From</label>
                <input type="date" name="fromDate" required><br>

                <label>To</label>
                <input type="date" name="toDate" id="toDate" required><br>

                <input type="submit" value="SHOW">
            </form><br>

            <form action="overview.php?time=month" method="post">
                <h3>Month & Year</h3>
                <select class="monthSelector" id="selectedMonth" name="selectedMonth" required></select><br>
                <select class="yearSelector" id="selectedYear" name="selectedYear" required></select><br>
                <input type="submit" value="SHOW">
            </form><br>

            <form action="overview.php?time=year" method="post">
                <h3>Year</h3>
                <select class="yearSelector" id="displayYear" name="displayYear" required></select><br>
                <input type="submit" value="SHOW">
            </form><br>
        </details>

        <details>
            <summary>Filter data by category</summary>
            <form action="overview.php?category=expenses" method="post">
                <h3>Expenses category</h3>
                <select name="selectedCategory" required>
                    <?php fillCategoryOptions("expenses"); ?>
                </select><br>
                <input type="submit" value="SHOW">
            </form><br>

            <form action="overview.php?category=income" method="post">
                <h3>Income category</h3>
                <select name="selectedCategory" required>
                    <?php fillCategoryOptions("income"); ?>
                </select><br>
                <input type="submit" value="SHOW">
            </form><br>

            <form action="overview.php?category=investment" method="post">
                <h3>Investment category</h3>
                <select name="selectedCategory" required>
                    <?php fillCategoryOptions("investment"); ?>
                </select><br>
                <input type="submit" value="SHOW">
            </form>
        </details></br>

        <?php if (isset($_GET['time']) || isset($_GET['category'])) { ?>
            <form action="overview.php" method="POST">
                <input type="submit" value="RESET">
            </form></br>
        <?php } ?>

        <form action="/finances/index.php" method="POST">
            <input type="submit" value="MENU">
        </form>
    </aside>

    <main>
        <?php if (!isset($_GET['category'])) { ?>
            <div class="mainSection" id="left">
                <div id="chartTotalData"></div>
                <div id="chartInvestments"></div>
            </div>
            <div class="mainSection">
                <div id="chartCategoryExpenses"></div>
                <div id="chartCategoryIncome"></div>
            </div>
        <?php } else if (isset($_GET['category'])) { ?>
            <div class="mainSection" id="left">
                <div id="categoryChartMonths"></div>
            </div>
            <div class="mainSection">
                <div id="categoryChartYears"></div>
            </div>
        <?php } ?>

    </main>

</body>

</html>