<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <link rel="stylesheet" href="generalStyle.css" type="text/css">
    <link rel="stylesheet" href="/finances/index/index.css" type="text/css">
</head>
<body>
    <main>
    <?php 
        $wrongPassword = false; // Default: no wrong password introduced
        // If form has been submited -> check login
        if (isset($_POST['loginForm'])){
            require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelIndex.php"; 
            $login = login($_POST['user'], $_POST['password']);
            if ($login) { // login successful -> go to menu
                setcookie("user", $_POST['user'], time() + 60*60*24*30); // create cookie that expires in 30 days
                $hash = md5($_POST['user'] . getSalt($_POST['user']));
                setcookie("hash", $hash, time() + 60*60*24*30);
                header("Location:/finances/menu/menu.php");
                exit();
            } else { // wrong user - password -> display error
                $wrongPassword = true;
            }
        }
    ?>
        <form action="index.php" method="POST">
            <h1>Finance Manager</h1>
            <label for="user">User</label><br>
            <input type="text" name="user" id="user" class="inputField" required><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" class="inputField" required><br>
            <?php 
                // if wrong password was introduced
                if ($wrongPassword) {
                    echo "<label class='error' >Wrong data</label></br></br>";
                }
            ?>
            <input type="submit" name="loginForm" value="LOGIN" class="menuButton">
        </form>
    </main>
    
</body>
</html>