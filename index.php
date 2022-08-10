<!-- URL: http://localhost/finances/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance manager</title>
</head>
<body>
    <header></header>
    <div id="menu">
        <form action="/finances/newdata/newdata.php" method="POST">
            <input type="submit" value="ADD NEW DATA">
        </form>
        <form action="/finances/management/management.php" method="POST">
            <input type="submit" value="MANAGE DATA">
        </form>
        <form action="/finances/overview/overview.php" method="POST">
            <input type="submit" value="OVERVIEW">
        </form>
    </div>
</body>
</html>