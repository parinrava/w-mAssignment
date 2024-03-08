<?php
require_once '../../auth/authenticate.php';
require_once 'update.php';
require_once '../../include/navbar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id = $_GET['id'];

$bucket = get_bucket_id($db, $id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bucket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: lightblue;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="my-4">Update Bucket</h2>
        <form action="update.php" method="post" class="mb-3">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="form-group">
                <label for="transaction_name">Transaction Name:</label>
                <input type="text" id="transaction_name" name="transaction_name" value="<?php echo htmlspecialchars($bucket['transaction_name']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category">Category Name:</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($bucket['category']); ?>" class="form-control" required>
            </div>

            <input type="submit" value="Update" class="btn btn-primary bg-success ">
        </form>
</body>

</html>
<?php
require_once '../../include/footer.php';
?>