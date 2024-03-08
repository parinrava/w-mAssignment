<?php
require_once '../../db_config.php';
$db = database_connection(); 

function getLatestBalance($db)
{
    $result = $db->query("SELECT overall_balance FROM transactions ORDER BY transaction_date DESC, transaction_id DESC LIMIT 1");
    $row = $result->fetchArray();
    return $row ? $row['overall_balance'] : 0;
}



function getTransactionId($db, $id)
{
    $stmt = $db->prepare("SELECT * FROM transactions WHERE transaction_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $transaction = $result->fetchArray(SQLITE3_ASSOC);
    return $transaction;
}


function getTransactions($db)
{ $query = "SELECT t.*, b.category
              FROM transactions t
              LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'";

    $results = $db->query($query);
    $transactions = [];
    if ($results) {
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $transactions[] = $row;
        }
    } else {
        echo " Error: " . $db->lastErrorMsg();
    }
    return $transactions;
}



function getRecentBalance($db, $date)
{
    $stmt = $db->prepare("SELECT overall_balance FROM transactions WHERE transaction_date < ? ORDER BY transaction_date DESC LIMIT 1");
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $result = $stmt->execute();
    $balance = $result->fetchArray(SQLITE3_NUM);
    return $balance ? $balance[0] : 0;
}
