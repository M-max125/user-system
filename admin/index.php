<?php

session_start();
if(isset($_SESSION['username'])){
    header('location:admin-dashboard.php');
    exit();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styling.css">
</head>
<body class="bg-dark">
<div class="container h-100">
    <div class="row h-100 align-items-center justify-content-center">
        <div class="col-lg-5">
            <div class="card border-danger shadow-lg">
                <div class="card-header bg-danger">
                <h3 class="m-0 text-white"><i class="fas fa-user-cog"></i>&nbsp;Admin Panel Login</h3>
                </div>

                <div class="card-body">
                <form action="" method="post" class="px-3" id="admin-login-form">
                    
                    <div id="adminLoginAlert"></div>
                    
                    <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="Username" 
                    required autofocus>
                    </div>

                    <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="Password" 
                    required>
                    </div>

                    <div class="form-group">
                    <input type="submit" name="admin-login" class="btn btn-danger btn-block btn-lg rounded-0" 
                    value="Login" id="adminLoginBtn">
                    </div>

                
                </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
<script type="text/javascript" src="assets/js/index.js"></script>  
</body>
</html>