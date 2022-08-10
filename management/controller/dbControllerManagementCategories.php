<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementCategories.php";    

    // ------------------- TO EXECUTE ON PAGE LOAD -----------------
    // Delete record if pressed on delete
    if (isset($_POST['deleteCategory'])){
        deleteCategory($_POST['deleteId']);
        deleteExpensesByCategory($_POST['categoryRecord']);
    }
    // Edit record if pressed on change
    if (isset($_POST['changeCategory'])){
        editCategory($_POST['inputId'],$_POST['inputCategory']);  // Change category data
        editExpensesByCategory($_POST['oldCategory'], $_POST['inputCategory']); // Update new category value in existing records on expense table
    }


    // ------------------- FUNCTIONS --------------------------------
    // Function to fill the table with the income category values
    function fillCategoryTable(){
        // Get categories
        $categories = getCategories();
        while ($row = mysqli_fetch_assoc($categories)){            
            echo "<tr>";
                recordFormatCategory($row);
            echo "</tr>";    
        }
        echo "</table>"; // Close table html tag
        // If clicked on edit, add form element --> needs to be outside the table because form cannot be child of <table> / <tr> elements
        if (isset($_POST['edit'])){
            echo "<form action='management.php?data=categoriesexpenses' method='POST' id='changeCategoryForm'> </form>";
        }
    }

    // Print table row changing <td> data for <input text> in case edit was pressed. Only applied to record selected
    function recordFormatCategory($row){
        if (isset($_POST['edit']) && ($_POST['editId']) == $row['id']){
            // Here the form includes all the data in the cells inside to be sent to the DB
            echo "
                  <input type='hidden' value='".$row['id']."' name='inputId' form='changeCategoryForm' > 
                  <input type='hidden' value='".$row['category']."' name='oldCategory' form='changeCategoryForm' > 

                  <td><input type='text' value='".$row['category']."' name='inputCategory' form='changeCategoryForm' ></td>
                  <td><input type='submit' value='Change' name='changeCategory' form='changeCategoryForm' ></td>                       
                  
                  <td>
                    <form action='management.php?data=categoriesexpenses' method='POST'>
                        <input type='submit' value='Cancel' name='cancel'>
                    </form>
                  </td>";
        } else {
            // Here it is not necessary that the form contains all the data as it will not be changed in the DB
            echo "<td>".$row['category']."</td>                  
                  <td>
                        <form action='management.php?data=categoriesexpenses' method='POST'>
                            <input type='submit' value='Edit' name='edit'>
                            <input type='hidden' value='".$row['id']."' name='editId'>
                        </form>
                  </td>
                  <td>
                    <form action='management.php?data=categoriesexpenses' method='POST'>
                        <input type='submit' value='Delete' name='deleteCategory'>
                        <input type='hidden' value='".$row['id']."' name='deleteId'>
                        <input type='hidden' value='".$row['category']."' name='categoryRecord'> 
                    </form>
                </td>";
        }
    }

?>