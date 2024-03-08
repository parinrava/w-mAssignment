<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && !in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'registration.php'])) {
    header("Location: ../index.php");
    exit;
}
