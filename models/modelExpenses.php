<?php
require_once "coreModel.php";

// Insert expenses data in DB
function insertExpenses($concept, $category, $date, $amount){
    // conect to DB
    $db = connectDB();
    // Same format (upper - lower case) for all categories
    $category = ucfirst(strtolower($category));
    // Prepare query
    $sql_insert =$db->prepare("INSERT INTO expenses (concept, category, date, amount) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("sssd", $concept, $category, $date, $amount);
    $sql_insert->execute();
    // Close connections
    $sql_insert->close();
    mysqli_close($db);    
}
?>