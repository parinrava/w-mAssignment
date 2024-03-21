<?php
require_once 'include/navbar.php';
include 'db_config.php';
include 'upload/upload_form.php';
require_once 'auth/authenticate.php';

if (isset($_SESSION['message'])) {
 echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['message']) . "</div>";
 unset($_SESSION['message']); 
} elseif (isset($_SESSION['error-message'])) {
echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error-message']) . "</div>";
 unset($_SESSION['error-message']); 
}
$db = database_connection();
?>
    <style>
        body{
            background-color: lightblue;
        }
        .button{
            margin: 10px;
            padding: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 40%;
            background-color: green;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 20px;
        }
    </style>

</head>

<body>
    <div class="container">
        <div >
            <div>
            <button onclick="location.href='transaction_crud/Read/read_html.php'" class="button one">View all the Transactions</button>
            <button onclick="location.href='piechart/chart_html.php'" class="button two">View Transaction As Pie Chart</button>
            <button onclick="location.href='bucket_crud/Read/read_html.php'" class="button three">View Bucket</button>
                <?php
               if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                echo '<button onclick="location.href=\'admin/admin.php\'" class="button four">User Approval</button>';
            }
            ?>
            <div class="text-center">
                <button onclick="location.href='auth/logout.php'" class="btn btn-dark my-2">Log out</button>
            </div>
            
            </div>
        </div>
    </div>
</body>

</html>
<?php
require_once 'include/footer.php';
?>