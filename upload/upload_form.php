<?php
require_once 'auth/authenticate.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload CSV File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">upload your expense file here </h2>
                <form action="/upload/upload.php" method="post" enctype="multipart/form-data" class="form-group text-center">
                    <label for="transactionFile">choose your file then press upload button: </label>
                    <input type="file" name="transactionFile" id="transactionFile" class="form-control" required><br>
                    <input type="submit" value="Upload File" name="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

</body>

</html>
