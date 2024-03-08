<?php
require_once '../../db_config.php'; 
require_once '../crud_operations.php';
$id = null;
$db = database_connection(); 
$stmt = $db->prepare("SELECT * FROM buckets WHERE bucket_id = ?");
if ($stmt === false) {
    die($db->lastErrorMsg());
}
$stmt->bindValue(1, $id, SQLITE3_INTEGER);
$result = $stmt->execute();
// Fetch the transaction
$bucket = $result->fetchArray(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; 
    $transaction_name = $_POST['transaction_name'];
    $category = $_POST['category'];
    $stmt = $db->prepare("UPDATE buckets SET transaction_name = ?, category = ? WHERE bucket_id = ?");
    $stmt->bindValue(1, $transaction_name, SQLITE3_TEXT);
    $stmt->bindValue(2, $category, SQLITE3_TEXT);
    $stmt->bindValue(3, $id, SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: ../Read/read_html.php");
    exit();}
