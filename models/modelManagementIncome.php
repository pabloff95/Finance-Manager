<?php
    require_once "coreModel.php";
    
    // Retrieve income data from data base
    function getIncome($order){
        $db = connectDB();
        // Query
        $sql_select = "SELECT * FROM income ORDER BY ".$order;
        $result = mysqli_query($db, $sql_select);
        // Close
        mysqli_close($db);

        return $result;        
    }

    // Delete record form expenses category table
    function deleteIncome($id){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM income WHERE id = ?");
        $sql_delete->bind_param("i", $id);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Edit record in income table
    function editIncome($id, $income, $date, $amount, $category){
        $db = connectDB();
        // Query
        $sql_edit = $db->prepare("UPDATE income SET income = ?, date = ?, amount = ?, category = ? WHERE id = ?");
        $sql_edit->bind_param("ssisi", $income, $date, $amount, $category, $id);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }

?>