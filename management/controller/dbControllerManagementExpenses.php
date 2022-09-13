<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementExpenses.php";    

    // ------------------- TO EXECUTE ON PAGE LOAD -----------------
    // Delete record if pressed on delete
    if (isset($_POST['deleteExpense'])){
        deleteExpense($_POST['deleteId']);
    }
    // Edit record if pressed on change
    if (isset($_POST['changeExpense'])){
        editExpense($_POST['inputId'],$_POST['inputAmount'],$_POST['inputConcept'],$_POST['inputCategory'],$_POST['inputDate']);        
    }


    // ------------------- FUNCTIONS --------------------------------
    // Print data retrieved form DB
    function fillExpensesTable(){
        $expenses = getExpenses(tableOrder());
        // Get limits according to $_GET['page'] --> see "controllerNavigation.php"
        $lowLimit = getLimits()["lowerLimit"];
        $upLimit =  getLimits()["upperLimit"];
        $x = 1; // iterator, value to display data between the limits
        $printed = 0; // Keep track of printed table rows
        while($row = mysqli_fetch_assoc($expenses)){
            if ($x > $lowLimit && $x <= $upLimit) {  
                echo "<tr>";
                    recordFormatExpenses($row); // read function bellow           
                echo "</tr>";
                $printed++;
            }
            $x++;
        }
        // Fill with empty cells if there are not enough records
        for ($printed; $printed < $GLOBALS['records_per_page']; $printed++){
            echo "<tr><td colspan='100%' class='empty-row'>&nbsp;</td></tr>";
        }
        echo "</table>"; // Close table html tag
        // If clicked on edit, add form element --> needs to be outside the table because form cannot be child of <table> / <tr> elements
        if (isset($_POST['edit'])){
            echo "<form action='management.php?data=expenses&page=".$_GET['page']."' method='POST' id='changeExpenseForm'> </form>";
        }
    }

    // Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
    function recordFormatExpenses($row){
        if (isset($_POST['edit']) && ($_POST['editId']) == $row['id']){
            // Here the form includes all the data in the cells inside to be sent to the DB
            echo "
                    <input type='hidden' value='".$row['id']."' name='inputId' form='changeExpenseForm'>
                                      
                    <td><input type='text' value='". moneyFormat($row['amount'])  ."' name='inputAmount' form='changeExpenseForm' class = 'inputField' ></td>
                    <td><input type='text' value='".$row['concept']."' name='inputConcept' form='changeExpenseForm' class = 'inputField' ></td>
                    <td>
                        <select name='inputCategory' form='changeExpenseForm' class = 'inputField' >";
                        printEditCategories($row['category']);
            echo        "<select>                        
                    </td>
                    <td><input type='date' value='".$row['date']."' name='inputDate' form='changeExpenseForm' class = 'inputField' ></td>
                    <td><input type='submit' value='Change' name='changeExpense' form='changeExpenseForm' class='tableButton'></td>
                                      
                  <td>
                    <form action='management.php?data=expenses&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Cancel' name='cancel' class='tableButton'>
                    </form>
                  </td>";
        } else {
            // Here it is not necessary that the form contains all the data as it will not be changed in the DB
            echo "<td>".moneyFormat($row['amount'])."</td>
                  <td>".$row['concept']."</td>
                  <td>".$row['category']."</td>
                  <td>".dateFormat($row['date'])."</td>
                  <td><form action='management.php?data=expenses&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Edit' name='edit' class='tableButton'>
                        <input type='hidden' value='".$row['id']."' name='editId'>
                      </form></td>
                  <td>
                    <form action='management.php?data=expenses&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Delete' name='deleteExpense' class='tableButton'>
                        <input type='hidden' value='".$row['id']."' name='deleteId'>
                    </form>
                  </td>";
        }
    }


    // Function to show possible categories when editing expenses records
    function printEditCategories($value){
        $categories = getUniqueCategories("expenses");
        while ($row = mysqli_fetch_assoc($categories)){
            if ($value == $row['category'] ){
                echo "<option selected>".$row['category']."</option>";
            } else {
                echo "<option>".$row['category']."</option>";
            }            
        }
    }

?>