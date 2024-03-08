<?php

require_once '../auth/authenticate.php'; 
require_once '../include/navbar.php'; 
require_once '../db_config.php'; 
$db = database_connection();
require_once 'chart.php';
$year = $_POST['year'] ?? null;

$availableYears = getAvailableYears($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summary Expenses of your transactions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: lightblue;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <h2 class="my-4">Expense Summary for <?php echo $year; ?></h2>
        <form action="chart_html.php" method="post" class="form-inline my-2">
            <label for="year" class="mr-2">Enter Year:</label>
            <input type="number" id="year" name="year" min="1999" max="2025" step="1" value="<?php echo $year; ?>" class="form-control mr-2" />
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>

        <?php
        if ($year) {
            if (in_array($year, $availableYears)) {
                generateExpensePieChart($db, $year);
        ?>
                <div style="display: flex; justify-content: center;">
                    <?php makeExpenseSummaryTable($db, $year); ?>
                </div>
        <?php
            } else {
                echo "<p class='alert alert-warning'>The selected year is not available. Please select one of the following years: ";
                echo implode(", ", $availableYears);
                echo "</p>";
            }
        }
        ?>
</body>

</html>