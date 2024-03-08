<?php

require_once '../../db_config.php';
require_once '../Read/Read.php';
$db = database_connection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $expense = empty($_POST['expense']) ? 0 : floatval($_POST['expense']);
    $deposit = empty($_POST['deposit']) ? 0 : floatval($_POST['deposit']);
    $latest_balance = getLatestBalance($db); 
    $new_balance = $latest_balance + $deposit - $expense;
    $stmt = $db->prepare("INSERT INTO transactions (transaction_date, name, expense, income, overall_balance) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $stmt->bindValue(2, $name, SQLITE3_TEXT);
    $stmt->bindValue(3, $expense, SQLITE3_FLOAT);
    $stmt->bindValue(4, $deposit, SQLITE3_FLOAT);
    $stmt->bindValue(5, $new_balance, SQLITE3_FLOAT);
    $stmt->execute();
    header("Location: ../Read/read_html.php");
    exit();
}
