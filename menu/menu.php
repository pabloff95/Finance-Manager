<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <link rel="stylesheet" href="../generalStyle.css" type="text/css">
    <link rel="stylesheet" href="menu.css" type="text/css">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/menu/menuController.php";     ?>
    <?php 
        // Check if user is logged (cookies exist) and check correct user (check hash cookie)
        if (md5($_COOKIE['user'] . getSalt($_COOKIE['user'])) != $_COOKIE['hash']) {
            header("Location:/finances/index.php");
            exit();
        }
    ?>
    <script src="controller/eventsController.js"></script>
</head>
<body>
    
    <main>
        <h1 class="main-title">FINANCE MANAGER</h1>
        <form action="/finances/newdata/newdata.php" method="POST">
            <input type="submit" value="ADD NEW DATA" class="menuButton">
        </form>
        <form action="/finances/management/management.php" method="POST">
            <input type="submit" value="MANAGE DATA" class="menuButton">
        </form>
        <form action="/finances/overview/overview.php" method="POST">
            <input type="submit" value="OVERVIEW" class="menuButton">
        </form>
        <form action="menu.php" method="POST">
            <input type="submit" value="EXPORT" class="menuButton">
            <input type="hidden" name="export">
        </form>
        <form action="menu.php" method="POST" enctype="multipart/form-data" id="importForm">
            <input type="button" value="IMPORT" class="menuButton" id="importSubmit"><br>    
            <input type="file" name="file" id="fileInput" style="visibility:hidden;">                        
            <input type="hidden" name="import">
        </form>
        <?php 
            if (isset($_POST['export'])){
                require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/export/controllerExport.php";
                exportData();
            } else if (isset($_POST['import'])){
                require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/import/importController.php";
                importFile();
            }
        ?>        
    </main>
    <aside>
        <div id="currentMonth">
            <?php currentMonth(); 
                  currentMonthInformation(); ?>
        </div>
    </aside>
</body>
</html>