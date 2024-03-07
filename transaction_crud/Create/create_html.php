<?php
require_once '../../auth/authenticate.php';
require_once '../../include/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your Transactions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">
        <form action="create.php" method="post" class="mb-4">
            <div class="form-group">
                <label for="date">Date of your transaction:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="expense">Expense:</label>
                <input type="number" id="expense" name="expense" min="0" step="0.01" oninput="deposit.value=''" class="form-control">
            </div>
            <div class="form-group">
                <label for="deposit">Deposit:</label>
                <input type="number" id="deposit" name="deposit" min="0" step="0.01" oninput="expense.value=''" class="form-control">
            </div>
            <input type="submit" value="Submit" class="btn btn-primary bg-green">
        </form>
        <script>
            let expense = document.getElementById('expense');
            let deposit = document.getElementById('deposit');

            expense.addEventListener('input', function() {
                if (this.value !== '') {
                    deposit.value = '';
                }
            });

            deposit.addEventListener('input', function() {
                if (this.value !== '') {
                    expense.value = '';
                }
            });
        </script>
</body>

</html>
<?php
require_once '../../include/footer.php';
?>