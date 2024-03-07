<?php

include 'database_setup.php';

$db = setup_database();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LandingPage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container text-center mt-5">
        <h1>Welcome to your bank transaction management page!</h1>
        <p class="lead">if you have an account login, if not register please.</p>
        <div class="mt-4">
            <button onclick="location.href='auth/registration.php'" class="btn btn-primary">Register</button>
            <button onclick="location.href='auth/login.php'" class="btn btn-secondary">Login</button>
        </div>
    </div>
</body>

</html>
<?php
require_once 'include/footer.php';
?>
