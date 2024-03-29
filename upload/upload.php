<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../db_config.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['transactionFile'])) {
    $uploadDir = '../'; 
    $uploadFile = $uploadDir . basename($_FILES['transactionFile']['name']);
    $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    if ($fileType !== 'csv') {
        $_SESSION['error-message'] = "Error: Only CSV files are allowed.";
    } elseif (!is_uploaded_file($_FILES['transactionFile']['tmp_name'])) {
        $_SESSION['error-message'] = "No file was uploaded.";
    } elseif (!is_writable($uploadDir)) {
        $_SESSION['error-message'] = "Upload directory is not writable.";
    } elseif (move_uploaded_file($_FILES['transactionFile']['tmp_name'], $uploadFile)) {
        $db = database_connection();
        importCSVToSQLite($uploadFile, $db); 
        $_SESSION['message'] = "The file has been uploaded and imported.";
    } else {
        $_SESSION['error-message'] = "There was an error uploading your file."; }
    header("Location: ../home.php"); 
    exit;
} else {
    $_SESSION['error-message'] = "No file uploaded or wrong method used.";
    header("Location: ../home.php"); 
    exit;}?>
