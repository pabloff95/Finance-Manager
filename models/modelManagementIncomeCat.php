<?php
    require_once "coreModel.php";

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

    // Edit expenses records associated with edited category
    function editIncomeByCategory($oldCategory, $newCategory){
        $db = connectDB();
        // Same format (upper - lower case) for all categories
        $newCategory = ucfirst(strtolower($newCategory));
        // Query
        $sql_edit = $db->prepare("UPDATE income SET category = ? WHERE category = ?");
        $sql_edit->bind_param("ss", $newCategory, $oldCategory);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }

?>