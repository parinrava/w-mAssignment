<?php
function generateExpensePieChart($db, $year)
{
    $data = [];
    $SQL_query = "SELECT
    CASE
      WHEN b.category IS NULL THEN 'Other'
      ELSE b.category
    END AS category,
    COALESCE(SUM(t.expense), 0) AS total_expense
    FROM transactions t
    LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'
    WHERE strftime('%Y', t.transaction_date) = :year
    GROUP BY category
    ORDER BY total_expense DESC";

    $stmt = $db->prepare($SQL_query);
    $stmt->bindValue(':year', $year, SQLITE3_TEXT);
    $results = $stmt->execute();

    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $data[] = array("label" => $row['category'], "y" => $row['total_expense']);
    }
    //gpt code
    echo '<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>';
    echo '<div id="chartContainer" style="height: 370px; width: 100%;"></div>';
    echo '<script>
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Expenses by Category for Year ' . $year . '"
            },
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"$\"",
                indexLabel: "{label} ({y})",
                dataPoints: ' . json_encode($data, JSON_NUMERIC_CHECK) . '
            }]
        });
        chart.render();
    </script>';
}

function getAvailableYears($db)
{
    $result = $db->query("SELECT DISTINCT strftime('%Y', transaction_date) as year FROM transactions ORDER BY year");
    $years = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $years[] = $row['year'];
    }
    return $years;
}

function makeExpenseSummaryTable($db, $year)
{
    $SQL_query = "SELECT
    CASE
      WHEN b.category IS NULL THEN 'Other'
      ELSE b.category
    END AS category,
    COALESCE(SUM(t.expense), 0) AS total_expense
    FROM transactions t
    LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'
    WHERE strftime('%Y', t.transaction_date) = :year
    GROUP BY category
    ORDER BY total_expense DESC";

    $stmt = $db->prepare($SQL_query);
    $stmt->bindValue(':year', $year, SQLITE3_TEXT);
    $results = $stmt->execute();

    echo "<table border='1'>";
    echo "<tr><th>Category</th><th>Total Expense</th></tr>";

    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        echo "<tr><td>{$row['category']}</td><td>{$row['total_expense']}</td></tr>";
    }

    echo "</table>";
}

?>