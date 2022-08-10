<?php
    require_once "coreModel.php";

    // Retrieve expenses data from data base
    function getExpenses($order){
        $db = connectDB();
        // Query
        $sql_select = "SELECT * FROM expenses ORDER BY ". $order;
        $result = mysqli_query($db, $sql_select);
        // Close
        mysqli_close($db);

        return $result;        
    }

    // Delete record form expenses table
    function deleteExpense($id){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM expenses WHERE id = ?");
        $sql_delete->bind_param("i", $id);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Edit record in expenses table
    function editExpense($id, $amount,$concept, $category, $date){
        $db = connectDB();
        // Query
        $sql_edit = $db->prepare("UPDATE expenses SET concept = ?, category = ?, date = ?, amount = ? WHERE id = ?");
        $sql_edit->bind_param("sssii", $concept, $category, $date, $amount, $id);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }


?>
