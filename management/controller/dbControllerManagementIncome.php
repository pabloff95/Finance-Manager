<?php

require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementIncome.php";    

// ------------------- TO EXECUTE ON PAGE LOAD -----------------
// Delete record if pressed on delete
if (isset($_POST['deleteIncome'])){
    deleteIncome($_POST['deleteId']);
}
// Edit record if pressed on change
if (isset($_POST['changeIncome'])){
    editIncome($_POST['inputId'],$_POST['inputConcept'], $_POST['inputDate'], $_POST['inputAmount'], $_POST['inputCategory']);        
}


// ------------------- FUNCTIONS --------------------------------
// Function to fill the table with the income values
function fillIncomeTable(){
    // Get limits according to $_GET['page'] --> see "controllerNavigation.php"
    $lowLimit = getLimits()["lowerLimit"];
    $upLimit =  getLimits()["upperLimit"];
    $x = 1; // iterator, value to display data between the limits
    $printed = 0; // Keep track of printed table rows
    // Get income data
    $income = getIncome(tableOrder());
    while ($row = mysqli_fetch_assoc($income)){   
        if ($x > $lowLimit && $x <= $upLimit) {         
            echo "<tr>";
                recordFormatIncome($row);
            echo "</tr>";    
            $printed++;
        }
        $x++;
    }
    // Fill with empty cells if there are not enough records
    for ($printed; $printed < 5; $printed++){
        echo "<tr><td colspan='100%' class='empty-row'>&nbsp;</td></tr>";
    }
    echo "</table>"; // Close table html tag
    // If clicked on edit, add form element --> needs to be outside the table because form cannot be child of <table> / <tr> elements
    if (isset($_POST['edit'])){
        echo "<form action='management.php?data=income&page=".$_GET['page']."' method='POST' id='changeIncomeForm'> </form>";
    }
}

// Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
function recordFormatIncome($row){
    if (isset($_POST['edit']) && ($_POST['editId']) == $row['id']){
        // Here the form includes all the data in the cells inside to be sent to the DB
        echo "
              <input type='hidden' value='".$row['id']."' name='inputId' form='changeIncomeForm' > 

              <td><input type='text' value='".$row['amount']."' name='inputAmount' form='changeIncomeForm' class = 'inputField' ></td>
              <td><input type='text' value='".$row['concept']."' name='inputConcept' form='changeIncomeForm' class = 'inputField' ></td>
              <td>
                    <select name='inputCategory' form='changeIncomeForm' class = 'inputField' >";
                    printEditCategoriesIncome($row['category']);
              echo "<select>                        
              </td>
              <td><input type='date' value='".$row['date']."' name='inputDate' form='changeIncomeForm' class = 'inputField' ></td>
              <td><input type='submit' value='Change' name='changeIncome' form='changeIncomeForm' class='tableButton'></td>                       
              
              <td>
                <form action='management.php?data=income&page=".$_GET['page']."' method='POST'>
                    <input type='submit' value='Cancel' name='cancel' class='tableButton'>
                </form>
              </td>";
    } else {
        // Here it is not necessary that the form contains all the data as it will not be changed in the DB
        echo "<td>".$row['amount']."</td>
              <td>".$row['concept']."</td>                  
              <td>".$row['category']."</td>
              <td>".$row['date']."</td>
              <td>
                    <form action='management.php?data=income&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Edit' name='edit' class='tableButton'>
                        <input type='hidden' value='".$row['id']."' name='editId'>
                    </form>
              </td>
              <td>
                <form action='management.php?data=income&page=".$_GET['page']."' method='POST'>
                    <input type='submit' value='Delete' name='deleteIncome' class='tableButton'>
                    <input type='hidden' value='".$row['id']."' name='deleteId'>
                </form>
            </td>";
    }
}

// Function to show possible categories when editing expenses records
function printEditCategoriesIncome($value){
    $categories = getCategoriesIncome();
    while ($row = mysqli_fetch_assoc($categories)){
        if ($value == $row['category'] ){
            echo "<option selected>".$row['category']."</option>";
        } else {
            echo "<option>".$row['category']."</option>";
        }            
    }
}


?>