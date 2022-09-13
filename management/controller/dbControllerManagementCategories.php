<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementCategories.php";    

    // ------------------- TO EXECUTE ON PAGE LOAD -----------------
    // Delete record if pressed on delete
    if (isset($_POST['deleteCategory'])){
        deleteExpensesByCategory($_POST['categoryRecord']); // Delete expense with given category from expenses table
    }
    // Edit record if pressed on change
    if (isset($_POST['changeCategory'])){
        editExpensesByCategory($_POST['oldCategory'], $_POST['newCategory']); // Update new category value in existing records on expense table
    }


    // ------------------- FUNCTIONS --------------------------------
    // Function to fill the table with the income category values
    function fillCategoryTable(){
        // Get limits according to $_GET['page'] --> see "controllerNavigation.php"
        $lowLimit = getLimits()["lowerLimit"];
        $upLimit =  getLimits()["upperLimit"];
        $x = 1; // iterator, value to display data between the limits
        $printed = 0; // Keep track of printed table rows
        // Get categories
        $categories = getUniqueCategories("expenses");
        while ($row = mysqli_fetch_assoc($categories)){      
            if ($x > $lowLimit && $x <= $upLimit) {         
                echo "<tr>";
                    recordFormatCategory($row);
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
            echo "<form action='management.php?data=categories_expenses&page=".$_GET['page']."' method='POST' id='changeCategoryForm'> </form>";
        }
    }

    // Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
    function recordFormatCategory($row){
        if (isset($_POST['edit']) && ($_POST['categoryReference']) == $row['category']){
            // Here the form includes all the data in the cells inside to be sent to the DB
            echo "
                    <input type='hidden' value='".$row['category']."' name='oldCategory' form='changeCategoryForm' > 
                    <td><input type='text' value='".$row['category']."' name='newCategory' form='changeCategoryForm' class = 'inputField' ></td>
                    <td><input type='submit' value='Change' name='changeCategory' form='changeCategoryForm'  class='tableButton'></td>                                         
                  <td>
                    <form action='management.php?data=categories_expenses&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Cancel' name='cancel'  class='tableButton'>
                    </form>
                  </td>";
        } else {
            // Here it is not necessary that the form contains all the data as it will not be changed in the DB
            echo "<td>".$row['category']."</td>                  
                  <td>
                        <form action='management.php?data=categories_expenses&page=".$_GET['page']."' method='POST'>
                            <input type='submit' value='Edit' name='edit' class='tableButton'>
                            <input type='hidden' value='".$row['category']."' name='categoryReference'>
                        </form>
                  </td>
                  <td>
                    <form action='management.php?data=categories_expenses&page=".$_GET['page']."' method='POST'>
                        <input type='submit' value='Delete' name='deleteCategory' class='tableButton'>
                        <input type='hidden' value='".$row['category']."' name='categoryRecord'> 
                    </form>
                </td>";
        }
    }
    
?>