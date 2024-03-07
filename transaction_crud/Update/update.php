<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../database_setup.php';
require_once '../Read/Read.php';

// PHP to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $expense = empty($_POST['expense']) ? 0 : floatval($_POST['expense']);
    $income = empty($_POST['income']) ? 0 : floatval($_POST['income']);

    // Check if both expense and income are entered
    if ($expense > 0 && $income > 0) {
        $_SESSION['message'] = "Error: Only either the expense or income should be entered, not both.";
        $_SESSION['form_data'] = $_POST; // Store the form data in the session
        header("Location: update_html.php?id=$id"); // Redirect back to the update page
        exit;
    }

    // Prepare the SQL UPDATE statement
    $stmt = $db->prepare("UPDATE transactions SET transaction_date = ?, name = ?, expense = ?, income = ? WHERE transaction_id = ?");
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $stmt->bindValue(2, $name, SQLITE3_TEXT);
    $stmt->bindValue(3, $expense, SQLITE3_FLOAT);
    $stmt->bindValue(4, $income, SQLITE3_FLOAT);
    $stmt->bindValue(5, $id, SQLITE3_INTEGER);

    $stmt->execute();

    $stmt = $db->prepare("SELECT * FROM transactions WHERE transaction_date >= ? ORDER BY transaction_date ASC");
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $result = $stmt->execute();

    $overall_balance = get_last_balance_before($db, $date); 

    while ($transaction = $result->fetchArray(SQLITE3_ASSOC)) {
        $overall_balance += $transaction['income'] - $transaction['expense'];

        $stmt = $db->prepare("UPDATE transactions SET overall_balance = ? WHERE transaction_id = ?");
        $stmt->bindValue(1, $overall_balance, SQLITE3_FLOAT);
        $stmt->bindValue(2, $transaction['transaction_id'], SQLITE3_INTEGER);
        $stmt->execute();
    }

    header("Location: ../../transaction_crud/Read/read_html.php");
    exit;
}
