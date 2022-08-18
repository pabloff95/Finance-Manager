<!-- URL: http://localhost/finances/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
    <link rel="stylesheet" href="generalStyle.css" type="text/css">
    <link rel="stylesheet" href="index/index.css" type="text/css">
</head>
<body>
    <main>
        <h1>FINANCE MANAGER</h1>
        <form action="/finances/newdata/newdata.php" method="POST">
            <input type="submit" value="ADD NEW DATA" class="menuButton">
        </form>
        <form action="/finances/management/management.php" method="POST">
            <input type="submit" value="MANAGE DATA" class="menuButton">
        </form>
        <form action="/finances/overview/overview.php" method="POST">
            <input type="submit" value="OVERVIEW" class="menuButton">
        </form>
        <form action="index.php" method="POST">
            <input type="submit" value="EXPORT" class="menuButton">
            <input type="hidden" name="export">
        </form>
        <?php 
            if (isset($_POST['export'])){
                require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/export/controllerExport.php";
                exportData();
            }
        ?>
    </main>
</body>
</html>