<?php
 
 include_once('session.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

 $nuser = new Notes();

 //Handle Add New Note Ajax Request

 if(isset($_POST['action']) && $_POST['action'] == 'add_note'){
     
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);

    $nuser->add_new_note($cid,$title,$note);
    $nuser->notification($cid,'admin','Note added');
 }

 //Handle Display Notes Ajax Request

 if(isset($_POST['action']) && $_POST['action'] == 'display_notes'){
     $output = '';

     $notes = $nuser->get_notes($cid);

    if($notes){
        $output .=' <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
//Use substr(string,start,length) to fetch only 75 characters from the note body
//Using $row['id'] as the id enables to grab the id of the current note selected for performing the action
//respectively to view details, or edit or delete
        foreach($notes as $row){
            $output .='<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['title'].'</td>
            <td>'.substr($row['note'],0,75).'...</td>
            <td>
            <a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn">
            <i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

            <a href="#" id="'.$row['id'].'" title="Edit Note" class="text-primary editBtn">
            <i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editNoteModal"></i></a>&nbsp;

            <a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteBtn">
            <i class="fas fa-trash-alt fa-lg"></i></a>
            </td>
            </tr>';
        }
        $output .= '</tbody>
                    </table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( You have not written any note yet! Feel free to write your first note!</h3>';
    }
 }

 //Handle Edit Note of User Ajax Request

 if(isset($_POST['edit_id'])){
     
    $id = $_POST['edit_id'];

    $row = $nuser->edit_note($id);

    echo json_encode($row);
 }

//Handle Edit Note User Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'update_note'){

    $id = $nuser->test_input($_POST['id']);
    $title = $nuser->test_input($_POST['title']);
    $note = $nuser->test_input($_POST['note']);

    $nuser->update_note($id,$title,$note);
    $nuser->notification($cid,'admin','Note updated');
    
}

//Handle Delete Note User Ajax Request

if(isset($_POST['del_id'])){

    $id = $_POST['del_id'];

    $nuser->delete_note($id);
    $nuser->notification($cid,'admin','Note deleted');
}

//Handle Display Details Note User Ajax Request

if(isset($_POST['info_id'])){

    $id = $_POST['info_id'];

    $row = $nuser->edit_note($id);

    echo json_encode($row);
}

//Handle Profile Update Ajax Request

if(isset($_FILES['image'])){
    
    $name = $nuser->test_input($_POST['name']);
    $gender = $nuser->test_input($_POST['gender']);
    $dob = $nuser->test_input($_POST['dob']);
    $phone = $nuser->test_input($_POST['phone']);
    
    $oldImage = $_POST['oldimage'];//This is name attribute from the hidden input used in profile.php

    $folder = 'uploads/';

    if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")){
        
        
        $newImage = $folder.$_FILES['image']['name'];

        move_uploaded_file($_FILES['image']['tmp_name'],$newImage);

        if($oldImage != null){
            unlink($oldImage);//If there is already a photo , we delete it using unlink
        }
    }
    else{
        $newImage = $oldImage;
    }
    $nuser->update_profile($name,$gender,$dob,$phone,$newImage,$cid);
    $nuser->notification($cid,'admin','Profile updated');
}

//Handle Change Password Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'change-pass'){
    
    $currentPass = $_POST['curpass'];
    $newPass = $_POST['newpass'];
    $cnewPass = $_POST['cnewpass'];

    $hnewPass = password_hash($newPass,PASSWORD_DEFAULT);

    if($newPass != $cnewPass){
        echo $nuser->showMessage('danger','Passwords do not match');
    }else{
        if(password_verify($currentPass,$cpass)){
            $nuser->change_password($hnewPass,$cid);
            echo $nuser->showMessage('success','Password Changed Successfully!');
            $nuser->notification($cid,'admin','Password changed');
        }else{
            echo $nuser->showMessage('danger','Your Current Password is Wrong!');
        }
    }
}

//Handle Verify Email Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'verify-email'){
    try{
           
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = Database::USERNAME;
        $mail->Password = Database::PASSWORD;
        $mail->SMTPSecure= PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(Database::USERNAME,'MCode League');
        $mail->addAddress($cemail);//$cemail is the currently user stored in session.php

        $mail->isHTML(true);
        $mail->Subject ='Email Verification';
        $mail->Body = '<h3>Click the link below to verify your Email.<br><a
        href="http://localhost/user-system/verify-email.php?email='.$cemail.'
        ">http://localhost/user-system/verify-email.php?email='.$cemail.'</a><br>
        Regards,<br>MCode League</h3>';

        $mail->send();
        echo $nuser->showMessage('success','Verification Link Sent to Your E-mail!Please check your mail!');
    }
    catch(Exception $e){
        echo $nuser->showMessage('danger','Something went wrong.Please try again later!');
    }
}

//Handle Feedback Sending to Admin

if(isset($_POST['action']) && $_POST['action'] == 'feedback'){
    
    $subject = $nuser->test_input($_POST['subject']);
    $feedback = $nuser->test_input($_POST['feedback']);

    $nuser->send_feedback($subject,$feedback,$cid);
    $nuser->notification($cid,'admin','Feedback written');
       
    
    
}
//Handle Fetch User Notification Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'fetchNotification'){

    $notification = $nuser->fetchNotification($cid);

    $output = '';

    if($notification){
        foreach($notification as $row){
            $output .='<div class="alert alert-danger" role="alert">
                    <button type="button" class="close" id="'.$row['id'].'"data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">New Notification</h4>
                    <p class="mb-0 lead">'.$row['message'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left">Feedback Reply from Admin </p>
                    <p class="mb-0 float-right">'.$nuser->timeAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                    </div>';
        }
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary mt-5">There are no new notifications</h3>';
    }
}

//Check Notification Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'checkNotification'){
    if($nuser->fetchNotification($cid)){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>';
    }else{
        echo '';
    }
}

//Handle Remove Notification Ajax Request

if(isset($_POST['notification_id'])){

    $id = $_POST['notification_id'];
    $nuser->removeNotification($id);
}



?>