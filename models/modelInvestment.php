<?php 
    require_once "coreModel.php";

    function insertInvestment($category, $concept, $date, $amount, $share){
        $db = connectDB();
        // Query
        $sql_insert = $db->prepare("INSERT INTO investment (category, concept, date, amount, share) VALUES (?,?,?,?,?)");
        $sql_insert->bind_param("sssis", $category, $concept, $date, $amount, $share);
        $sql_insert->execute();
        // Close
        $sql_insert->close();
        mysqli_close($db);
    }



?>