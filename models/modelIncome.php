<?php
require_once "coreModel.php";

// Insert expenses data in DB
function insertIncome($income, $date, $amount, $category){
    // conect to DB
    $db = connectDB();
    // Same format (upper - lower case) for all categories
    $category = ucfirst(strtolower($category));
    // Prepare query
    $sql_insert =$db->prepare("INSERT INTO income (concept, date, amount, category) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("ssds", $income, $date, $amount, $category);
    $sql_insert->execute();
    // Close connections
    $sql_insert->close();
    mysqli_close($db);    
}

?>