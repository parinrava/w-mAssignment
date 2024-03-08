<?php
include 'db_config.php';
$db = create_db(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>LandingPage</title>
            <style>

    body{
        background-color: lightblue;
    }
    .button1{
        margin: 10px;
        padding: 10px;
        font-size: 20px;
        background-color: green;
        display: block;
        margin-left: auto;
        margin-right: auto;
        border: greenyellow;
    }

    .button2{
        margin: 10px;
        padding: 10px;
        font-size: 20px;
         background-color: lightgreen; 
        display: block;
        margin-left: auto;
        margin-right: auto;
        border: greenyellow;

    }
    h1{  text-align: center; }

</style>
</head>
<body>
    <div>
        <h1 >Welcome to your bank transaction management page!</h1>
        <div>
        <button class ="button1" onclick="location.href='auth/registration.php'">Register</button>
        </div>
            <div>
            <button class ="button2" onclick="location.href='auth/login.php'">Login</button>
            </div>
    </div>
</body>

</html>
<?php require_once 'include/footer.php';?>
