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

// Function to get all unique categories of a given table
function getUniqueCategories($table){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT DISTINCT category FROM " . $table;
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


// Get user salt
function getSalt ($user){
    $db = connectDB();
    // Query
    $sql_select = $db->prepare("SELECT salt FROM users WHERE user = ?");
    $sql_select->bind_param("s", $user);
    $sql_select->execute();
    // Get result    
    $result = $sql_select->get_result();
    if ($result->num_rows > 0 ){
        $salt =  $result->fetch_assoc()['salt'];    
        return $salt;
    } else {
        return false;
    }
}
?>