<?php
require "../Read/read.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM transactions WHERE transaction_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: ../Read/read_html.php?message=Transaction+deleted+successfully");    exit;
}
?>
