<?php

require_once '../../auth/authenticate.php';
require_once '../../include/navbar.php';
require './Read.php'; 
$db = database_connection(); 
if (isset($_GET['message'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['message']) . "</div>";}

// gpt code
echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'>Transaction Table</h1>";
echo "<button onclick=\"location.href='../../transaction_crud/Create/create_html.php?'\" class='btn btn-success mb-3'>Create Transaction</button>";
echo "<table class='table'>";
echo "<thead class='thead-dark'>";
echo "<tr>
        <th>ID</th>
        <th>Date</th>
        <th>Name</th>
        <th>Expense</th>
        <th>Income</th>
        <th>Overall Balance</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>";
echo "</thead>";
echo "<tbody>";
$transactions = getTransactions($db);
foreach ($transactions as $transaction) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($transaction['transaction_id']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['transaction_date']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['name']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['expense']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['income']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['overall_balance']) . "</td>";
    $category = empty($transaction['category']) ? 'Other' : htmlspecialchars($transaction['category']);
    echo "<td>" . $category . "</td>"; 
    echo "<td>";
    echo "<button onclick=\"location.href='../../transaction_crud/Update/update_html.php?id=" . $transaction['transaction_id'] . "'\" class='btn btn-primary mr-2'>Update</button>";
    echo "<button onclick=\"location.href='../../transaction_crud/Delete/delete.php?id=" . $transaction['transaction_id'] . "'\" class='btn btn-success'>Delete</button>";
    echo "</td>";
    echo "</tr>";}
echo "</tbody>";
echo "</table>";
?>
<style>
    body {
        background-color: lightblue;
    }
</style>

<?php
require_once '../../include/footer.php';
?>