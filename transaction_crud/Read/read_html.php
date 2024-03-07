<?php

require_once '../../auth/authenticate.php';
require_once '../../include/navbar.php';
// =========================
require './Read.php'; // Assuming this path is correct and `read.php` is in the same directory

$db = connect_database(); // Ensure the database connection is set up

if (isset($_GET['message'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['message']) . "</div>";
}

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

$transactions = get_transactions($db);

foreach ($transactions as $transaction) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($transaction['transaction_id']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['transaction_date']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['name']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['expense']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['income']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['overall_balance']) . "</td>";
    $category = empty($transaction['category']) ? 'Other' : htmlspecialchars($transaction['category']);
    echo "<td>" . $category . "</td>"; // Display the category
    echo "<td>";
    echo "<button onclick=\"location.href='../../transaction_crud/Update/update_html.php?id=" . $transaction['transaction_id'] . "'\" class='btn btn-primary mr-2'>Update</button>";
    echo "<button onclick=\"location.href='../../transaction_crud/Delete/delete.php?id=" . $transaction['transaction_id'] . "'\" class='btn btn-danger'>Delete</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>


</body>

</html>
<?php
require_once '../../include/footer.php';
?>