<?php
    require_once "coreModel.php";

    // Delete record form expenses category table
    function deleteCategory($id){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM categories_expenses WHERE id = ?");
        $sql_delete->bind_param("i", $id);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Delete record form expenses category table
    function deleteExpensesByCategory($category){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM expenses WHERE category = ?");
        $sql_delete->bind_param("s", $category);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Edit record in expenses category table
    function editCategory($id, $category){
        $db = connectDB();
        // Query
        $sql_edit = $db->prepare("UPDATE categories_expenses SET category = ? WHERE id = ?");
        $sql_edit->bind_param("si", $category, $id);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }

    // Edit expenses records associated with edited category
    function editExpensesByCategory($oldCategory, $newCategory){
        $db = connectDB();
        // Query
        $sql_edit = $db->prepare("UPDATE expenses SET category = ? WHERE category = ?");
        $sql_edit->bind_param("ss", $newCategory, $oldCategory);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }
?>