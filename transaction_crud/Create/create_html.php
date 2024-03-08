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
    <style>
        body {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <form action="create.php" method="post" class="mb-4">
            <div class="form-group">
                <label for="date">Date of your transaction:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="name">Name of the Transaction:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="expense">Expense:</label>
                <input type="number" id="expense" name="expense" min="0" step="0.01" oninput="deposit.value=''" class="form-control">
                <p> Note: you cannot have expense and deposit together</p>
            </div>
            <div class="form-group">
                <label for="deposit">Deposit:</label>
                <input type="number" id="deposit" name="deposit" min="0" step="0.01" oninput="expense.value=''" class="form-control">
            </div>
            <input type="submit" value="Submit" class="btn btn-primary bg-green">
        </form>
</body>
</html>
<?php
require_once '../../include/footer.php';
?>
<!-- functionality to choose either expense or deposite not both at the same time -->
        <script>
            let expenseSection = document.getElementById('expense');
            let depositAmount = document.getElementById('deposit');
            expenseSection.addEventListener('input', function() {
                if (this.value !== '') {
                    depositAmount.value = '';
                }});
            depositAmount.addEventListener('input', function() {
                if (this.value !== '') {
                    expenseSection.value = '';}});
        </script>