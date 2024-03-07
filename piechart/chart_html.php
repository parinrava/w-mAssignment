<?php

require_once '../auth/authenticate.php'; // Go two levels up and into the auth directory
require_once '../include/navbar.php'; // Go two levels up and into the include directory
require_once '../database_setup.php'; // Go two levels up to the project root
$db = connect_database();

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
</head>

<body>
    <div class="container text-center">
        <h2 class="my-4">Expense Summary for <?php echo $year; ?></h2>

        <!-- Form to select year -->
        <form action="chart_html.php" method="post" class="form-inline my-2">
            <label for="year" class="mr-2">Enter Year:</label>
            <input type="number" id="year" name="year" min="1990" max="2099" step="1" value="<?php echo $year; ?>" class="form-control mr-2" />
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>

        <?php
        if ($year) {
            if (in_array($year, $availableYears)) {
                generateExpensePieChart($db, $year);
        ?>
                <div style="display: flex; justify-content: center;">
                    <?php generateExpenseSummaryTable($db, $year); ?>
                </div>
        <?php
            } else {
                echo "<p class='alert alert-warning'>The selected year is not available. Please select one of the following years: ";
                echo implode(", ", $availableYears);
                echo "</p>";
            }
        }
        ?>

<button onclick="location.href='../Read/read_html.php'" class="btn btn-secondary bg-success">Back</button>
</body>

</html>