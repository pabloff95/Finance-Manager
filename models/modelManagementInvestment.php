<?php
    require_once "coreModel.php";

    // Retrieve investment data from data base
    function getInvestments($order){
        $db = connectDB();
        // Query
        if ($order == "date") {
            $sql_select = "SELECT * FROM investment ORDER BY ". $order . " DESC";
        } else {
            $sql_select = "SELECT * FROM investment ORDER BY ". $order;
        }
        $result = mysqli_query($db, $sql_select);
        // Close
        mysqli_close($db);

        return $result;        
    }


    // Delete record from investment table
    function deleteInvestment($id){
        $db = connectDB();
        // Query
        $sql_delete = $db->prepare("DELETE FROM investment WHERE id = ?");
        $sql_delete->bind_param("i", $id);
        $sql_delete->execute();
        // Close connecitons
        $sql_delete->close();
        mysqli_close($db);
    }

    // Edit record in investment table
    function editInvestment($category, $concept, $date, $amount, $share, $id){
        $db = connectDB();
        // Same format (upper - lower case) for all categories
        $category = ucfirst(strtolower($category));
        // Same format for all shares
        $share = strtoupper($share);
        // Query
        $sql_edit = $db->prepare("UPDATE investment SET category = ?, concept = ?, date = ?, amount = ?, share = ? WHERE id = ?");
        $sql_edit->bind_param("sssdsi", $category, $concept, $date, $amount, $share, $id);
        $sql_edit->execute();
        // Close connecitons
        $sql_edit->close();
        mysqli_close($db);
    }

    // Get investment unique categories
    function getInvestmentCategories(){
        $db = connectDB();
        // Query
        $sql_select = "SELECT DISTINCT category AS category FROM investment";
        $result = mysqli_query($db, $sql_select);
        // Close
        mysqli_close($db);

        return $result;        
    }
?>