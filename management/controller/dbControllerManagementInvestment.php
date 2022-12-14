<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementInvestment.php";    

    // ------------------- TO EXECUTE ON PAGE LOAD -----------------
    // Delete record if pressed on delete
    if (isset($_POST['deleteInvestment'])){
        deleteInvestment($_POST['deleteId']);
    }
    // Edit record if pressed on change
    if (isset($_POST['changeInvestment'])){    
        if (!isset($_POST['inputShare'])) {
            $share = "";
        } else {
            $share = $_POST['inputShare'];
        }
        editInvestment($_POST['inputCategory'], $_POST['inputConcept'], $_POST['inputDate'], $_POST['inputAmount'], $share, $_POST['inputId']);
    }

    
    // ------------------- FUNCTIONS --------------------------------
    // Function to fill the table with the investment values
    function fillInvestmentTable(){
        // Get limits according to $_GET['page'] --> see "controllerNavigation.php"
        $lowLimit = getLimits()["lowerLimit"];
        $upLimit =  getLimits()["upperLimit"];
        $x = 1; // iterator, value to display data between the limits
        $printed = 0; // Keep track of printed table rows
        // Get categories
        $investments = getInvestments(tableOrder());
        while ($row = mysqli_fetch_assoc($investments)){
            if ($x > $lowLimit && $x <= $upLimit) {         
                echo "<tr>";
                    recordFormatInvestment($row);
                echo "</tr>";
                $printed++;
            }
            $x++;
        }
        // Fill with empty cells if there are not enough records
        for ($printed; $printed < $GLOBALS['records_per_page']; $printed++){
            echo "<tr><td colspan='100%' class='empty-row'>&nbsp;</td></tr>";
        }
        echo "</table>";// Close table html tag
        // If clicked on edit, add form element --> needs to be outside the table because form cannot be child of <table> / <tr> elements
        if (isset($_POST['edit'])){
            echo "<form action='management.php?data=investment&page=".$_GET['page']."' method='POST' id='changeInvestmentForm'> </form>";
        }
    }

    // Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
function recordFormatInvestment($row){
    if (isset($_POST['edit']) && ($_POST['editId']) == $row['id']){
        // Here the form includes all the data in the cells inside to be sent to the DB
        echo "
              <input type='hidden' value='".$row['id']."' name='inputId' form='changeInvestmentForm' > 

              <td>
                <select name='inputCategory' form='changeInvestmentForm' id='categorySelected' class = 'inputField' >";
                printEditCategoriesInvestment($row['category']);        
        echo    "<select>     
              </td>
              <td><input type='text' value='".$row['concept']."' name='inputConcept' form='changeInvestmentForm' class = 'inputField' ></td>
              <td><input type='text' value='".$row['share']."' name='inputShare' id='shareField' form='changeInvestmentForm' class = 'inputField' ></td>
              <td><input type='date' value='".$row['date']."' name='inputDate' form='changeInvestmentForm' class = 'inputField' ></td>
              <td><input type='text' value='".moneyFormat($row['amount'])."' name='inputAmount' form='changeInvestmentForm' class = 'inputField' ></td>
              <td><input type='submit' value='Change' name='changeInvestment' form='changeInvestmentForm' class='tableButton'></td>                       
              
              <td>
                <form action='management.php?data=investment&page=".$_GET['page']."' method='POST'>
                    <input type='submit' value='Cancel' name='cancel' class='tableButton'>
                </form>
              </td>";
    } else {
        // Here it is not necessary that the form contains all the data as it will not be changed in the DB
        echo "<td>".$row['category']."</td>                    
              <td>".$row['concept']."</td>
              <td>".$row['share']."</td>
              <td>".dateFormat($row['date'])."</td>
              <td>".moneyFormat($row['amount'])."</td>        
              <td>
                    <form action='management.php?data=investment&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Edit' name='edit' class='tableButton'>
                        <input type='hidden' value='".$row['id']."' name='editId'>
                    </form>
              </td>
              <td>
                <form action='management.php?data=investment&page=".$_GET['page']."' method='POST'>
                    <input type='submit' value='Delete' name='deleteInvestment' class='tableButton'>
                    <input type='hidden' value='".$row['id']."' name='deleteId'>
                </form>
            </td>";
    }
}


// Function to show possible categories when editing investment records
function printEditCategoriesInvestment($value){
    $categories = ["Stock", "Bond", "Fund", "Property", "Other"]; // Investment categories
    for($i = 0; $i < count($categories); $i++){
        if ($value == $categories[$i]){
            echo "<option selected>".$categories[$i]."</option>";
        } else {
            echo "<option>".$categories[$i]."</option>";
        }
    }
}

?>