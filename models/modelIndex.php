<?php
require_once "coreModel.php";

// Check user login
function login($user, $password){
    $db = connectDB();
    // Prepare password (password + salt)
    $salt = getSalt($user);
    if ($salt) { // user exists
        $password = $password . $salt;
    } else { // user does not exist
        mysqli_close($db);
        return false;
    }
    // Query
    $sql_select = $db->prepare("SELECT password FROM users WHERE user = ?");
    $sql_select->bind_param("s", $user);
    $sql_select->execute();
    // Store DB password in variable
    $sql_select->store_result();
    $sql_select->bind_result($dbpassword);
    $sql_select->fetch();
     // Check password
     if (password_verify($password, $dbpassword)) {
        $sql_select->close();  
        mysqli_close($db);
        return true;
    } else {
        $sql_select->close();  
        mysqli_close($db);
        return false;
    }    
}

?>