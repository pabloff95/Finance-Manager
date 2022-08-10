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
        while($row = mysqli_fetch_assoc($expenses)){
            echo "<tr>";
                recordFormatExpenses($row); // read function bellow           
            echo "</tr>";
        }
        echo "</table>"; // Close table html tag
        // If clicked on edit, add form element --> needs to be outside the table because form cannot be child of <table> / <tr> elements
        if (isset($_POST['edit'])){
            echo "<form action='management.php?data=expenses' method='POST' id='changeExpenseForm'> </form>";
        }
    }

    // Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
    function recordFormatExpenses($row){
        if (isset($_POST['edit']) && ($_POST['editId']) == $row['id']){
            // Here the form includes all the data in the cells inside to be sent to the DB
            echo "
                    <input type='hidden' value='".$row['id']."' name='inputId' form='changeExpenseForm'>

                    <td><input type='text' value='".$row['amount']."' name='inputAmount' form='changeExpenseForm' ></td>
                    <td><input type='text' value='".$row['concept']."' name='inputConcept' form='changeExpenseForm'></td>
                    <td>
                        <select name='inputCategory' form='changeExpenseForm'>";
                        printEditCategories($row['category']);
            echo        "<select>                        
                    </td>
                    <td><input type='date' value='".$row['date']."' name='inputDate' form='changeExpenseForm'></td>
                    <td><input type='submit' value='Change' name='changeExpense' form='changeExpenseForm'></td>
                                      
                  <td>
                    <form action='management.php?data=expenses' method='POST'>
                        <input type='submit' value='Cancel' name='cancel'>
                    </form>
                  </td>";
        } else {
            // Here it is not necessary that the form contains all the data as it will not be changed in the DB
            echo "<td>".$row['amount']."</td>
                  <td>".$row['concept']."</td>
                  <td>".$row['category']."</td>
                  <td>".$row['date']."</td>
                  <td><form action='management.php?data=expenses' method='POST'>
                        <input type='submit' value='Edit' name='edit'>
                        <input type='hidden' value='".$row['id']."' name='editId'>
                      </form></td>
                  <td>
                    <form action='management.php?data=expenses' method='POST'>
                        <input type='submit' value='Delete' name='deleteExpense'>
                        <input type='hidden' value='".$row['id']."' name='deleteId'>
                    </form>
                  </td>";
        }
    }


    // Function to show possible categories when editing expenses records
    function printEditCategories($value){
        $categories = getCategories();
        while ($row = mysqli_fetch_assoc($categories)){
            if ($value == $row['category'] ){
                echo "<option selected>".$row['category']."</option>";
            } else {
                echo "<option>".$row['category']."</option>";
            }            
        }
    }


?>