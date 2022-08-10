<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
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

    // Require controllers
    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelExpenses.php";     // required to use getCategories()
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementExpenses.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementCategories.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementIncome.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementCatIncome.php"; 
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/management/controller/dbControllerManagementInvestment.php"; 

    ?>    
    <script src="controller/eventsController.js"></script>
</head>
<body>

    <!-- SCREEN CONTROLLED BY $_GET['data']:
        - When not existing -> displays normal menu to chose data to manage
        - When setted to expenses -> displays expenses management menu
        - When setted to income -> displays income management menu
        - When setted to categories -> displays caegories management menu
    -->

    <?php if (!isset($_GET['data'])) { ?>     
        <form action="management.php?data=expenses" method="POST">
            <input type="submit" value="EXPENSES">
        </form>
        <form action="management.php?data=income" method="POST">
            <input type="submit" value="INCOME">
        </form>
        <form action="management.php?data=investment" method="POST">
            <input type="submit" value="INVESTMENTS">
        </form>
        <form action="management.php?data=categoriesexpenses" method="POST">
            <input type="submit" value="CATEGORIES EXPENSES">
        </form>
        <form action="management.php?data=categoriesincome" method="POST">
            <input type="submit" value="CATEGORIES INCOME">
        </form>
        

    <!-- MANAGE EXPENSES --> 
    <?php } else if ($_GET['data'] == "expenses"){ ?>
        <table>
            <tr>
                <th>
                    <form action='management.php?data=expenses' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Cost">
                        <input type="hidden" name="order" value="amount">
                    </form>                    
                </th>
                <th>
                    <form action='management.php?data=expenses' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Concept">
                        <input type="hidden" name="order" value="concept">
                    </form>                    
                </th>
                <th>
                    <form action='management.php?data=expenses' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Category">
                        <input type="hidden" name="order" value="category">
                    </form>                    
                </th>
                <th>
                    <form action='management.php?data=expenses' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Date">
                        <input type="hidden" name="order" value="date">
                    </form>                    
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillExpensesTable(); ?>
        

    <!-- MANAGE INCOME --> 
    <?php } else if ($_GET['data'] == "income") {?>
        <table>
            <tr>
                <th>
                    <form action='management.php?data=income' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Amount">
                        <input type="hidden" name="order" value="amount">
                    </form>                        
                </th>
                <th>
                    <form action='management.php?data=income' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Income">
                        <input type="hidden" name="order" value="income">
                    </form>   
                </th>
                <th>
                    <form action='management.php?data=income' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Category">
                        <input type="hidden" name="order" value="category">
                    </form>                    
                </th>
                <th>
                    <form action='management.php?data=income' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Date">
                        <input type="hidden" name="order" value="date">
                    </form>                    
                </th>             
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillIncomeTable(); ?>

    <!-- MANAGE CATEGORIES  EXPENSES --> 
    <?php } else if ($_GET['data'] == "categoriesexpenses") {?>
        <table>
            <tr>
                <th>Category</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillCategoryTable(); ?>
        
    <!-- MANAGE CATEGORIES  INCOME --> 
    <?php } else if ($_GET['data'] == "categoriesincome") {?>
        <table>
            <tr>
                <th>Category</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillCategoryIncomeTable(); ?>
    
    <!-- MANAGE INVESTMENT --> 
    <?php } else if ($_GET['data'] == "investment") {?>
        <table>
            <tr>
                <th>
                    <form action='management.php?data=investment' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Category">
                        <input type="hidden" name="order" value="category">
                    </form>    
                </th>
                <th>
                    <form action='management.php?data=investment' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Concept">
                        <input type="hidden" name="order" value="concept">
                    </form>    
                </th>
                <th>
                    <form action='management.php?data=investment' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Share">
                        <input type="hidden" name="order" value="share">
                    </form>    
                </th>                
                <th>
                    <form action='management.php?data=investment' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Date">
                        <input type="hidden" name="order" value="date">
                    </form>    
                </th>
                <th>
                    <form action='management.php?data=investment' method='POST' id='changeExpenseForm'> 
                        <input type="submit" value="Amount">
                        <input type="hidden" name="order" value="amount">
                    </form>    
                </th>                
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php fillInvestmentTable(); ?>
        
    <?php } ?>            

    
    <!-- BACK TO MENU (shared by all other menus)--> 
    <form action="/finances/index.php" method="POST">
        <input type="submit" value="MENU">
    </form>
</body>
</html>