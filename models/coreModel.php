<?php
// Connect to DB to perform queries
function connectDB(){
    // Parameters
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "finances";
    // Connection
    $connection = mysqli_connect($host, $user, $pass, $db);
    return $connection;
}

// Get all data from a given table
function getData($table){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT * FROM ". $table . " ORDER BY date ASC";
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}
// Get all data from a given table (same as above, but unordered)
function getAllData($table){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT * FROM ". $table;
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}
?>