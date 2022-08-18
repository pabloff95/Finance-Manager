<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <link rel="stylesheet" href="/finances/generalStyle.css" type="text/css">
    <link rel="stylesheet" href="management.css" type="text/css">
    <?php 
    // return order of records to be displayed on the table
        // Function declared here because is used by all controllers
        function tableOrder(){
            session_start();
            if (isset($_POST['order'])){            
                $_SESSION['order'] = $_POST['order'];
                return $_POST['order'];
            } else if (isset($_SESSION['order'])){
                // if pressed previously during this session
                return $_SESSION['order'];
            }
             else {
                // Default value: order by date
                return "date";
            }
        }

    // Require controllers and model
    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelExpenses.php";     // required to use getCategories()
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/controllerNavigation.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementExpenses.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementCategories.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementIncome.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementCatIncome.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementInvestment.php"; 
    

    ?>    
    <script src="controller/eventsController.js"></script>
</head>
<body>
    <main>
    <!-- SCREEN CONTROLLED BY $_GET['data']:
        - When not existing -> displays normal menu to chose data to manage
        - When setted to expenses -> displays expenses management menu
        - When setted to income -> displays income management menu
        - When setted to categories -> displays caegories management menu
    -->

    <?php if (!isset($_GET['data'])) { ?>     
        <div id="managementMenu">
            <form action="management.php?data=expenses&page=1" method="POST" class="menuForm">
                <input type="submit" value="EXPENSES" class="menuButton">
            </form>
            <form action="management.php?data=income&page=1" method="POST" class="menuForm">
                <input type="submit" value="INCOME" class="menuButton">
            </form>
            <form action="management.php?data=investment&page=1" method="POST" class="menuForm">
                <input type="submit" value="INVESTMENTS" class="menuButton">
            </form>
            <form action="management.php?data=categories_expenses&page=1" method="POST" class="menuForm">
                <input type="submit" value="CATEGORIES EXPENSES" class="menuButton">
            </form>
            <form action="management.php?data=categories_income&page=1" method="POST" class="menuForm">
                <input type="submit" value="CATEGORIES INCOME" class="menuButton">
            </form>
            <form action="/finances/index.php" method="POST" class="menuForm">
                <input type="submit" value="MENU" class="menuButton">
            </form>
        </div>
        

    <!-- MANAGE EXPENSES --> 
    <?php } else if ($_GET['data'] == "expenses"){ ?>
        <div class="table">
            <h1 class="title">Manage expenses</h1>
        <table>
            <tr>
                <th class="header">
                    <form action='management.php?data=expenses&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Cost" class="headerButton">
                        <input type="hidden" name="order" value="amount">
                    </form>                    
                </th>
                <th class="header">
                    <form action='management.php?data=expenses&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Concept" class="headerButton">
                        <input type="hidden" name="order" value="concept">
                    </form>                    
                </th>
                <th class="header">
                    <form action='management.php?data=expenses&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Category" class="headerButton">
                        <input type="hidden" name="order" value="category">
                    </form>                    
                </th>
                <th class="header">
                    <form action='management.php?data=expenses&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Date" class="headerButton">
                        <input type="hidden" name="order" value="date">
                    </form>                    
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillExpensesTable(); ?>

            <div class="navigation-container">
                <form action="<?php getURLBackward(); ?>" method="POST">
                    <input type="submit" value="<<<" class="navigation-button" name="backwardNavigation">
                </form>
                <form action="<?php getURLForward(); ?>" method="POST">
                    <input type="submit" value=">>>" class="navigation-button" name="forwardNavigation">
                </form>
            </div>

            <form action="/finances/index.php" method="POST">
                <input type="submit" value="MENU" class="formButton">
            </form>
        </div>

    <!-- MANAGE INCOME --> 
    <?php } else if ($_GET['data'] == "income") {?>
        <div class="table">
            <h1 class="title">Manage income</h1>
        <table>
            <tr class="header-row">
                <th class="header">
                    <form action='management.php?data=income&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Amount" class="headerButton">
                        <input type="hidden" name="order" value="amount">
                    </form>                        
                </th>
                <th class="header">
                    <form action='management.php?data=income&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Income" class="headerButton">
                        <input type="hidden" name="order" value="concept">
                    </form>   
                </th>
                <th class="header">
                    <form action='management.php?data=income&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Category" class="headerButton">
                        <input type="hidden" name="order" value="category">
                    </form>                    
                </th>
                <th class="header">
                    <form action='management.php?data=income&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Date" class="headerButton">
                        <input type="hidden" name="order" value="date">
                    </form>                    
                </th>             
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillIncomeTable(); ?>

            <div class="navigation-container">
                <form action="<?php getURLBackward(); ?>" method="POST">
                    <input type="submit" value="<<<" class="navigation-button" name="backwardNavigation">
                </form>
                <form action="<?php getURLForward(); ?>" method="POST">
                    <input type="submit" value=">>>" class="navigation-button" name="forwardNavigation">
                </form>
            </div>

            <form action="/finances/index.php" method="POST">
                <input type="submit" value="MENU" class="formButton">
            </form>
        </div>

    <!-- MANAGE CATEGORIES  EXPENSES --> 
    <?php } else if ($_GET['data'] == "categories_expenses") {?>
        <div class="table">
            <h1 class="title">Manage categories expenses</h1>
        <table>
            <tr>
                <th>Category</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillCategoryTable(); ?>

            <div class="navigation-container">
                <form action="<?php getURLBackward(); ?>" method="POST">
                    <input type="submit" value="<<<" class="navigation-button" name="backwardNavigation">
                </form>
                <form action="<?php getURLForward(); ?>" method="POST">
                    <input type="submit" value=">>>" class="navigation-button" name="forwardNavigation">
                </form>
            </div>

            <form action="/finances/index.php" method="POST">
                <input type="submit" value="MENU" class="formButton">
            </form>
        </div>

    <!-- MANAGE CATEGORIES  INCOME --> 
    <?php } else if ($_GET['data'] == "categories_income") {?>
        <div class="table">
            <h1 class="title">Manage categories income</h1>
        <table>
            <tr>
                <th>Category</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillCategoryIncomeTable(); ?>

            <div class="navigation-container">
                <form action="<?php getURLBackward(); ?>" method="POST">
                    <input type="submit" value="<<<" class="navigation-button" name="backwardNavigation">
                </form>
                <form action="<?php getURLForward(); ?>" method="POST">
                    <input type="submit" value=">>>" class="navigation-button" name="forwardNavigation">
                </form>
            </div>

            <form action="/finances/index.php" method="POST">
                <input type="submit" value="MENU" class="formButton">
            </form>
        </div>
    
    <!-- MANAGE INVESTMENT --> 
    <?php } else if ($_GET['data'] == "investment") {?>
        <div class="table">
            <h1 class="title">Manage investment</h1>
        <table>
            <tr>
                <th class="header">
                    <form action='management.php?data=investment&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Category" class="headerButton">
                        <input type="hidden" name="order" value="category">
                    </form>    
                </th>
                <th class="header">
                    <form action='management.php?data=investment&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Concept" class="headerButton">
                        <input type="hidden" name="order" value="concept">
                    </form>    
                </th>
                <th class="header">
                    <form action='management.php?data=investment&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Share" class="headerButton">
                        <input type="hidden" name="order" value="share">
                    </form>    
                </th>                
                <th class="header">
                    <form action='management.php?data=investment&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Date" class="headerButton">
                        <input type="hidden" name="order" value="date">
                    </form>    
                </th>
                <th class="header">
                    <form action='management.php?data=investment&page=1' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Amount" class="headerButton">
                        <input type="hidden" name="order" value="amount">
                    </form>    
                </th>                
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillInvestmentTable(); ?>

            <div class="navigation-container">
                <form action="<?php getURLBackward(); ?>" method="POST">
                    <input type="submit" value="<<<" class="navigation-button" name="backwardNavigation">
                </form>
                <form action="<?php getURLForward(); ?>" method="POST">
                    <input type="submit" value=">>>" class="navigation-button" name="forwardNavigation">
                </form>
            </div>

            <form action="/finances/index.php" method="POST">
                <input type="submit" value="MENU" class="formButton">
            </form>
        </div>
        
    <?php } ?>            
    
    </main>
</body>
</html>