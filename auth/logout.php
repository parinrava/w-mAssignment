<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();}



$_SESSION = array();
if (ini_get("session.use_cookies")) { 
    $params = session_get_cookie_params();
    setcookie( 
        session_name(),
        '',
        time() - 42000, // Set the expiration time to the past
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}


session_destroy();  
header("Location: ../index.php");
exit;
?>