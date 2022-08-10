<?php
    require_once "coreModel.php";
    require_once "modelIncome.php"; // get getCategoriesIncome()

    // Delete category of income_category table
    function deleteCatIncome($id){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM categories_income WHERE id = ?");
        $sql_delete->bind_param("i", $id);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Delete record from income_category table
    function deleteIncomeByCategory($category){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM income WHERE category = ?");
        $sql_delete->bind_param("s", $category);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Edit category in income_category table
    function editCatIncome($category, $id){
        $db = connectDB();
        // Query
        $sql_update = $db->prepare("UPDATE categories_income SET category = ? WHERE id = ?");
        $sql_update->bind_param("si", $category, $id);
        $sql_update->execute();
        // Close connecitons
        $sql_update->close();
        mysqli_close($db);
    }

    // Edit expenses records associated with edited category
    function editIncomeByCategory($oldCategory, $newCategory){
        $db = connectDB();
        // Query
        $sql_edit = $db->prepare("UPDATE income SET category = ? WHERE category = ?");
        $sql_edit->bind_param("ss", $newCategory, $oldCategory);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }

?>