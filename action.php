<?php
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


include_once('autoloader.inc.php');

$user = new Auth();
//Handle Ajax Register Request

 if(isset($_POST['action']) && $_POST['action'] == 'register'){
     $name = $user->test_input($_POST['name']);
     $email = $user->test_input($_POST['email']);
     $pass = $user->test_input($_POST['password']);

     $hpass = password_hash($pass,PASSWORD_DEFAULT);

     if($user->user_exist($email)){
         echo $user->showMessage('warning','This E-mail is already registered!');
     }
     else{
         if($user->register($name,$email,$hpass)){
                echo 'register';
                $_SESSION['user'] = $email;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = Database::USERNAME;
                $mail->Password = Database::PASSWORD;
                $mail->SMTPSecure= PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom(Database::USERNAME,'MCode League');
                $mail->addAddress($email);//$cemail is the currently user stored in session.php

                $mail->isHTML(true);
                $mail->Subject ='Email Verification';
                $mail->Body = '<h3>Click the link below to verify your Email.<br><a
                href="http://localhost/user-system/verify-email.php?email='.$email.'
                ">http://localhost/user-system/verify-email.php?email='.$email.'</a><br>
                Regards,<br>MCode League</h3>';

                $mail->send();

         }else{
             echo $user->showMessage('danger','Something went wrong! Try again later!');
         }
     }
 }

 //Handle Login Ajax Request

 if(isset($_POST['action']) && $_POST['action'] == 'login'){
     $email = $user->test_input($_POST['email']);
     $pass = $user->test_input($_POST['password']);

     $loggedInUser = $user->login($email);

     if($loggedInUser != null){
         if(password_verify($pass,$loggedInUser['password'])){
             if(!empty($_POST['rem'])){
                 setcookie("email",$email,time()+(30*24*60*60),'/');
                 setcookie("password",$pass,time()+(30*24*60*60),'/');
             }
             else{
                 setcookie("email","",1,'/');
                 setcookie("password","",1,'/');
             }
             echo 'login';
             $_SESSION['user'] = $email;
         }
         else{
             echo $user->showMessage('danger','The password is incorrect');
         }
     }else{
         echo $user->showMessage('danger','User not found!');
     }
 }

 //Handle Forgot Password  Ajax Request

 if(isset($_POST['action']) && $_POST['action'] == 'forgot'){
     
    $email = $user->test_input($_POST['email']);
    $user_found = $user->currentUser($email);

    if($user_found != null){
        $token = uniqid();
        $token = str_shuffle($token);

        $user->forgot_password($token,$email);

        try{
           
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = Database::USERNAME;
            $mail->Password = Database::PASSWORD;
            $mail->SMTPSecure= PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(Database::USERNAME,'MCode League');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject ='Reset Password';
            $mail->Body = '<h3>Click the link below to reset your password.<br><a
            href="http://localhost/user-system/reset-pass.php?email='.$email.'
            &token='.$token.'">http://localhost/user-system/reset-pass.php?email='.$email.'
            &token='.$token.'</a><br>Regards,<br>MCode League</h3>';

            $mail->send();
            echo $user->showMessage('success','We have sent the reset link to your e-mail ID, please check
            your e-mail adress!');
        }
        catch(Exception $e){
            echo $user->showMessage('danger','Something went wrong.Please try again later!');
        }
    }
    else{
        echo $user->showMessage('info','This e-mail is not registered!');
    }
 }

 

?>