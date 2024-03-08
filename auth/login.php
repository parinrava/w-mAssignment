<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();}
require_once '../db_config.php'; 
$db = database_connection(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; 
    $stmt = $db->prepare("SELECT user_id, email, password_hash, is_approved, is_admin FROM users WHERE email = ?");
    $stmt->bindValue(1, $email, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['is_approved'] == 1) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['email'] = $user['email'];
            header("Location: ../home.php");
            exit();
        } else { $error = "Your account needs approval from the admin approval."; }
    } else { $error = "Invalid email or password.";
    }
}
if (isset($_SESSION['user_id'])) {
    header("Location: ../home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: lightskyblue;
        }
        .form-group {
            margin: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
       
        }
        input{
            width: 100%;
            border: none;
            border-radius: 20px;
            background-color: plum;
            font-size: 20px;

        }
        #btn {
            margin: 10px;
            width: 40%;
            padding:15px;
            display: block;
            margin-left: auto;
            margin-right: auto;

        }
        .text-center {
            text-align: center;
        }
        .container {
            margin-top: 100px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .alert {
            margin: 10px;
        }
    </style>
</head>
<body>
    <div >
        <h2 style="font-size:40px;" class="text-center">Login Here: </h2>
        <?php if (!empty($error)) : ?>
            <div>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post" class="form-group">
            <label style="font-size:20px; " for="email">your Email:</label>
            <input type="email" id="email" name="email" class="form-control" required><br>
            <label style="font-size:20px; " for="password">your Password:</label>
            <input type="password" id="password" name="password" class="form-control" required><br>
            <input type="submit" value="Login" id="btn">
        </form>
    </div>
</body>

</html>