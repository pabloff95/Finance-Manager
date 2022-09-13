<?php 
    require_once "coreModel.php";

    function insertInvestment($category, $concept, $date, $amount, $share){
        $db = connectDB();
        // Same format (upper - lower case) for all categories
        $category = ucfirst(strtolower($category));
        // Same format (upper - lower case) for all share names
        $share = strtoupper($share);
        // Query
        $sql_insert = $db->prepare("INSERT INTO investment (category, concept, date, amount, share) VALUES (?,?,?,?,?)");
        $sql_insert->bind_param("sssds", $category, $concept, $date, $amount, $share);
        $sql_insert->execute();
        // Close
        $sql_insert->close();
        mysqli_close($db);
    }



?>