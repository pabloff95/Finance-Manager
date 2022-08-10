<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementInvestment.php";    

    // ------------------- TO EXECUTE ON PAGE LOAD -----------------
    // Delete record if pressed on delete
    if (isset($_POST['deleteInvestment'])){
        deleteInvestment($_POST['deleteId']);
    }
    // Edit record if pressed on change
    if (isset($_POST['changeInvestment'])){    
        editInvestment($_POST['inputCategory'], $_POST['inputConcept'], $_POST['inputDate'], $_POST['inputAmount'], $_POST['inputShare'], $_POST['inputId']);
    }

    
    // ------------------- FUNCTIONS --------------------------------
    // Function to fill the table with the investment values
    function fillInvestmentTable(){
        $investments = getInvestments(tableOrder());
        while ($row = mysqli_fetch_assoc($investments)){
            echo "<tr>";
                recordFormatInvestment($row);
            echo "</tr>";
        }
        echo "</table>";// Close table html tag
        // If clicked on edit, add form element --> needs to be outside the table because form cannot be child of <table> / <tr> elements
        if (isset($_POST['edit'])){
            echo "<form action='management.php?data=investment' method='POST' id='changeInvestmentForm'> </form>";
        }
    }

    // Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
function recordFormatInvestment($row){
    if (isset($_POST['edit']) && ($_POST['editId']) == $row['id']){
        // Here the form includes all the data in the cells inside to be sent to the DB
        echo "
              <input type='hidden' value='".$row['id']."' name='inputId' form='changeInvestmentForm' > 

              <td>
                <select name='inputCategory' form='changeInvestmentForm' id='categorySelected'>";
                printEditCategoriesInvestment($row['category']);        
        echo    "<select>     
              </td>
              <td><input type='text' value='".$row['concept']."' name='inputConcept' form='changeInvestmentForm' ></td>
              <td><input type='text' value='".$row['share']."' name='inputShare' id='shareField' form='changeInvestmentForm' ></td>
              <td><input type='date' value='".$row['date']."' name='inputDate' form='changeInvestmentForm' ></td>
              <td><input type='text' value='".$row['amount']."' name='inputAmount' form='changeInvestmentForm' ></td>
              <td><input type='submit' value='Change' name='changeInvestment' form='changeInvestmentForm' ></td>                       
              
              <td>
                <form action='management.php?data=investment' method='POST'>
                    <input type='submit' value='Cancel' name='cancel'>
                </form>
              </td>";
    } else {
        // Here it is not necessary that the form contains all the data as it will not be changed in the DB
        echo "<td>".$row['category']."</td>                    
              <td>".$row['concept']."</td>
              <td>".$row['share']."</td>
              <td>".$row['date']."</td>
              <td>".$row['amount']."</td>        
              <td>
                    <form action='management.php?data=investment' method='POST'>
                        <input type='submit' value='Edit' name='edit'>
                        <input type='hidden' value='".$row['id']."' name='editId'>
                    </form>
              </td>
              <td>
                <form action='management.php?data=investment' method='POST'>
                    <input type='submit' value='Delete' name='deleteInvestment'>
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