<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();}
require_once '../db_config.php';
$db = database_connection();
$message = '';
if (isset($_GET['approved']) && $_GET['approved'] == 1) {
    $message = 'User has been approved!';}
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Unauthorized access.");}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user_ids'])) {
    $user_ids_to_approve = $_POST['approve_user_ids'];
    foreach ($user_ids_to_approve as $user_id) {
        $stmt = $db->prepare("UPDATE users SET is_approved = 1 WHERE user_id = ?");
        $stmt->bindValue(1, $user_id, SQLITE3_INTEGER);
        $stmt->execute();}
    $_SESSION['message'] = count($user_ids_to_approve) . ' User(s) have been approved!';
    header('Location: ../home.php');
    exit;}
$unapproved_users = $db->query("SELECT user_id, email FROM users WHERE is_approved = 0");
header('Location: admin.php');
exit;
?>
