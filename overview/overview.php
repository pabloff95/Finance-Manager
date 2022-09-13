<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <script src="controller/eventController.js"></script>

    <!-- $_GET variables:
        - time: used to control the charts when a specific periof of time / specific month / specific year is searched.
        Also displayed by default when there was no petition requested by the user (showing a summary of all data).
        - category: used to control charts when a specific category was requested by the user.
        - overview: used to control charts when general overview options have been selected
    -->
    <?php
        // Defined function here used by all controllers: define amount (€) format: xx.xx 
        function moneyFormat($amount){
            // Check natural numbers: xx
            if (ctype_digit($amount)){
                return ($amount . ".00");
            } else {
                $amount = round($amount,2);
                // Check normal currency numbers: xx.xx
                if (preg_match('/^[0-9]+(\.[0-9]{2})$/', $amount)){
                    return $amount;

                // Check only 1 decimal number: xx.x
                } else if (preg_match('/^[0-9]+(\.[0-9]{1})$/', $amount)){
                    return ($amount . "0");

                // Any other result
                } else {
                    return ($amount . ".00");
                }
            }
        }
    ?>
    <?php if (isset($_GET['time']) || (!isset($_GET['category']) && !isset($_GET['overview']))) { ?>
        <script src="controller/eventControllerTime.js"></script>
    <?php } else if (isset($_GET['category'])) { ?>
        <script src="controller/eventControllerCategory.js"></script>
    <?php } else if (isset($_GET['overview'])){ ?>
        <script src="controller/eventControllerOverview.js"></script>
    <?php } ?>

    <?php 
    require_once "controller/dbControllerTime.php"; 
    require_once "controller/dbControllerCategory.php"; 
    require_once "controller/dbControllerOverview.php"; 
    // Check if user is logged (cookies exist) and check correct user (check hash cookie)
    if (md5($_COOKIE['user'] . getSalt($_COOKIE['user'])) != $_COOKIE['hash']) {
        header("Location:/finances/index.php");
        exit();
    }

    // Manage session for general overview years chart: $_SESSION['year']
    session_start();
    if(!isset($_GET['overview']) && isset($_SESSION['year'])){
        unset($_SESSION['year']);
    }
    ?>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <link rel="stylesheet" href="../generalStyle.css" type="text/css">
    <link rel="stylesheet" href="overview.css" type="text/css">

    
</head>

<body>
    <header>
        <div id="header-container">            
            <div class="header-section">
                <form action="/finances/menu/menu.php" method="POST" id="menuButton">
                    <input type="submit" value="MENU" class="header-button">
                </form>
            </div>
            <div class="header-section">
                <h1 class="main-title">FINANCE HISTORY</h1>
            </div>
            <div class="header-section">
                <?php if (isset($_GET['time']) || isset($_GET['category']) || isset($_GET['overview'])) { ?>
                    <form action="overview.php" method="POST" id="resetButton">
                        <input type="submit" value="RESET" class="header-button" >
                    </form></br>
                <?php } ?>
            </div>
        </div>
        <?php hiddenCategories();
        if (isset($_GET['time']) || (!isset($_GET['category']) && !isset($_GET['overview']))) { ?>
            <input type="hidden" id="totalIncome" value="<?php echo moneyFormat(getTotalAmount("income")); ?>">
            <input type="hidden" id="totalExpenses" value="<?php echo moneyFormat(getTotalAmount("expenses")); ?>">
            <input type="hidden" id="totalInvestments" value="<?php echo moneyFormat(getTotalAmount("investment")); ?>">
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
        <?php } 
        
        if (isset($_GET['overview'])) { 
            if ($_GET['overview'] != "all") { ?>
                <input type="hidden" id="jsonOverviewData" value='<?php echo json_encode(yearlyOverviewArray($_GET['overview']), JSON_NUMERIC_CHECK); ?>'>
            <?php } else if ($_GET['overview'] == "all") { ?>
                <input type="hidden" id="jsonOverviewDataIncome" value='<?php echo json_encode(yearlyOverviewArray("income"), JSON_NUMERIC_CHECK); ?>'>
                <input type="hidden" id="jsonOverviewDataExpenses" value='<?php echo json_encode(yearlyOverviewArray("expenses"), JSON_NUMERIC_CHECK); ?>'>                
                <input type="hidden" id="jsonOverviewDataInvestment" value='<?php echo json_encode(yearlyOverviewArray("investment"), JSON_NUMERIC_CHECK); ?>'>        
    <?php } 
        } ?>   
    </header>
    
    <aside>

        <details class="search-form">
            <summary><h3>General overview</h3></summary>
            <form action="overview.php?overview=expenses&year=<?php echo getYears("expenses")[0]; ?>" method="POST">
                <input type="submit" value="EXPENSES" class="search-button" name="overviewForm">
            </form>
            <form action="overview.php?overview=income&year=<?php echo getYears("income")[0]; ?>" method="POST">
                <input type="submit" value="INCOME" class="search-button" name="overviewForm">
            </form>
            <form action="overview.php?overview=investment&year=<?php echo getYears("investment")[0]; ?>" method="POST">
                <input type="submit" value="INVESTMENTS" class="search-button" name="overviewForm">
            </form>
            <form action="overview.php?overview=all&year=<?php echo getYears("all")[0]; ?>" method="POST">
                <input type="submit" value="ALL" class="search-button" name="overviewForm">
            </form>
        </details><br>

        <details class="search-form">
            <summary><h3>Specific period</h3></summary>
            <form action="overview.php?time=period" method="POST">
                <label>From</label>
                <input type="date" name="fromDate" class="inputField" required><br>

                <label>To</label>
                <input type="date" name="toDate" id="toDate" class="inputField" required><br>

                <input type="submit" value="SHOW" class="search-button">
            </form>
        </details><br>

        <details class="search-form">
            <summary><h3>Month & Year</h3></summary>
            <form action="overview.php?time=month" method="post">
                <select class="monthSelector inputField" id="selectedMonth" name="selectedMonth" required></select><br>
                <select class="yearSelector inputField" id="selectedYear" name="selectedYear" required></select><br>
                <input type="submit" value="SHOW" class="search-button">
            </form>
        </details><br>

        <details class="search-form">
            <summary><h3>Year</h3></summary>
            <form action="overview.php?time=year" method="post">            
                <select class="yearSelector inputField" id="displayYear" name="displayYear" required></select><br>
                <input type="submit" value="SHOW" class="search-button">
            </form>
        </details><br>

        <details class="search-form">
            <summary><h3>Category search</h3></summary>
            <form action="" method="post" id="categoryForm"> <!-- action controlled from JS -->            
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
        </details><br>
        
        <?php
        // Add text explaining the information that is being displayed
        if (isset($_GET['time'])) {
            switch ($_GET['time']) {
                case "period":
                    echo "<p class='displayed-information'>
                            <b>Displaying:</b></br>". str_replace("-", "/", $_POST['fromDate']). " - ". str_replace("-", "/", $_POST['toDate'])."
                        </p>";
                    break;
                case "month":
                    echo "<p class='displayed-information'>
                            <b>Displaying:</b></br>". $_POST['selectedMonth']. " / ". $_POST['selectedYear']."
                        </p>";
                    break;
                case "year":
                    echo "<p class='displayed-information'>
                            <b>Displaying:</b></br>". $_POST['displayYear'] . "
                        </p>";
                    break;
            }
        } else if (isset($_GET['category'])){
            echo "<p class='displayed-information'>
                    <b>Displaying:</b></br>" . ucfirst($_GET['category']) . " (" . $_POST['selectedCategory']. ")
                </p>";
        }
        ?>
        

    </aside>

    <main>
        <?php if (isset($_GET['time']) || (!isset($_GET['category']) && !isset($_GET['overview']))) { ?>
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
                <div class="title-container"><p class="chart-title">MONTHLY</p></div>
                <div id="categoryChartMonths" class="chart"></div>
            </div>
            <div class="chart-container category">
                <div class="title-container"><p class="chart-title">YEARLY</p></div>
                <div id="categoryChartYears" class="chart"></div>
            </div>          

        <?php } else if (isset($_GET['overview'])) {  
            // Create or update session variable that keeps track of the current year being displayed (used by naviagtion forms)
            if (!isset($_SESSION['year']) || isset($_POST['overviewForm'])) {
                $_SESSION['year'] = getYears($_GET['overview'])[0];
            } else {
                updateSessionYear();
            }

            ?>
            
            <div id="overview-container">
                <div class="overview-title-container">
                    <div class="title-element">
                        <form action="<?php getNavigationURLBackward(); ?>" method="POST"> 
                            <input type="hidden" name="navigation" value="previous">
                            <input type="submit" value="<<<" class="title-button">
                        </form>                   
                    </div>
                    <div class="title-element">
                        <?php printTitle(); ?>
                    </div>
                    <div class="title-element">
                        <form action="<?php getNavigationURLForward(); ?>" method="POST">  
                            <input type="hidden" name="navigation" value="next">
                            <input type="submit" value=">>>" class="title-button">
                        </form>
                    </div>
                </div>
                <div id="overview-chart-container"></div>                
            </div>


        <?php } 
            session_write_close();
        ?>

    </main>

</body>

</html>