<?php
session_start();

include_once('autoloader.inc.php');
$luser = new Auth();

if($luser->is_logged_in()){
    header('location:home.php');
}

$luser->webClick();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCode League</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

<div class="container">
<!--Login Form-->

<div class="row justify-content-center wrapper" id="login-box">
    <div class="col-lg-10 my-auto">
        <div class="card-group myShadow">
            <div class="card rounded-left p-4" style="flex-grow:1.4;">
                <h1 class="text-center font-weight-bold text-primary">Sign in to your Account</h1>
                    <hr class="my-3">
                    
                    <form action="#" method="post" class="px-3" id="login-form">

                        <div id="loginAlert"></div>
                        
                        <div class="input-group input-group-lg form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="far fa-envelope fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="E-mail" required 
                                value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; }?>">
                        </div>
                        
                        <div class="input-group input-group-lg form-group"> 
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="fas fa-key fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password" required 
                                value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; }?>">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox float-left">
                                <input type="checkbox" name="rem" class="custom-control-input" id="customCheck" 
                                <?php if(isset($_COOKIE['email'])) {?> checked <?php } ?>>
                                <label for="customCheck" class="custom-control-label">Remember Me</label>
                            </div>

                            <div class="forgot float-right">
                                <a href="#" id="forgot-link">Forgot Password</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Sign In" id="login-btn" class="btn btn-primary btn-lg btn-block myBtn">
                        </div> 
                    </form>
            </div>

            <div class="card justify-content-center rounded-right myColor p-4">
                <h1 class="text-center font-weight-bold text-white">Hello People!</h1>
                <hr class="my-3 bg-light myHr">
                <p class="text-center font-weight-bolder text-light lead">Enter your personal details and start your experience with us!</p>
                <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="register-link">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<!--Login Form End-->

<!-- Register Form-->
<div class="row justify-content-center wrapper" id="register-box" style="display:none;">
    <div class="col-lg-10 my-auto">
        <div class="card-group myShadow">

            <div class="card justify-content-center rounded-left myColor p-4">
                <h1 class="text-center font-weight-bold text-white">Welcome Back!</h1>
                <hr class="my-3 bg-light myHr">
                <p class="text-center font-weight-bolder text-light lead">To keep connected with us please login using your personal info!</p>
                <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="login-link">Sign In</button>
            </div>
            
            <div class="card rounded-right p-4" style="flex-grow:1.4;">
                <h1 class="text-center font-weight-bold text-primary">Create Account</h1>
                    <hr class="my-3">
                    
                    <form action="#" method="post" class="px-3" id="register-form">
                    
                    <div id="regAlert"></div>
                        <div class="input-group input-group-lg form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="far fa-user fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Full Name" required>
                        </div>
                        
                        <div class="input-group input-group-lg form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="far fa-envelope fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="email" name="email" id="remail" class="form-control rounded-0" placeholder="E-mail" required>
                        </div>
                        
                        <div class="input-group input-group-lg form-group"> 
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="fas fa-key fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="password" name="password" id="rpassword" class="form-control rounded-0" placeholder="Password" required minlenght="5">
                        </div>

                        <div class="input-group input-group-lg form-group"> 
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="fas fa-key fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="password" name="cpassword" id="cpassword" class="form-control rounded-0" placeholder="Confirm Password" required minlenght="5">
                        </div>

                        <div class="form-group">
                            <div class="text-danger font-weight-bold" id="passError">
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <input type="submit" value="Sign Up" id="register-btn" class="btn btn-primary btn-lg btn-block myBtn">
                        </div> 
                    </form>
            </div>

            
        </div>
    </div>
</div>

<!-- Register Form end-->

<!-- Forgot Password Form-->
<div class="row justify-content-center wrapper" id="forgot-box" style="display:none;">
    <div class="col-lg-10 my-auto">
        <div class="card-group myShadow">

            <div class="card justify-content-center rounded-left myColor p-4">
                <h1 class="text-center font-weight-bold text-white">Reset Password</h1>
                <hr class="my-3 bg-light myHr">
                
                <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="back-link">Back</button>
            </div>
            
            <div class="card rounded-right p-4" style="flex-grow:1.4;">
                <h1 class="text-center font-weight-bold text-primary">Forgot Your Password?</h1>
                    <hr class="my-3">
                    <p class="lead text-center text-secondary">To reset your pasword enter the registered email adress and we will send you the reset intructions on your email!</p>
                    
                    <form action="#" method="post" class="px-3" id="forgot-form">
                        <div id="forgotAlert"></div>
                        
                        <div class="input-group input-group-lg form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">
                                <i class="far fa-envelope fa-lg"></i>
                                </span>
                                
                            </div>
                            <input type="email" name="email" id="femail" class="form-control rounded-0" placeholder="E-mail" required>
                        </div>
                        
                        

                        

                        <div class="form-group">
                            <input type="submit" value="Reset Password" id="forgot-btn" class="btn btn-primary btn-lg btn-block myBtn">
                        </div> 
                    </form>
            </div>

            
        </div>
    </div>
</div>

<!-- Forgot Password Form end-->
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
<script type="text/javascript" src="assets/js/forms.js"></script>
</body>
</html>