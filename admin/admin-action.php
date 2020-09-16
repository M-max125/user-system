<?php

include_once('../classes/Admin.class.php');
$admin = new Admin();
session_start();

//Handle Admin Login Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'admin-login'){
    
    $username = $admin->test_input($_POST['username']);
    $password = $admin->test_input($_POST['password']);

    $hpassword = sha1($password);

    $loggedInAdmin = $admin->admin_login($username,$hpassword);

    if($loggedInAdmin != null){
        echo 'admin_login';
        $_SESSION['username'] = $username;
    }else{
        echo $admin->showMessage('danger','Username or Password is Incorrect');
    }
}

//Handle FetchAllUsers Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers'){
    
    $output = '';
    $data = $admin->getRegUser(0);
    $path = '../';

    if($data){
        $output .= '<table class="table table-striped table-bordered text-center tableOne">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Verified</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        if($row['photo'] != ''){
                            $uphoto = $path.$row['photo'];
                        }else{
                           $uphoto = '../assets/images/avatar.jpeg';
                        }
                        $output .= '<tr>
                                    <td>'.$row['id'].'</td>
                                    <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.$row['phone'].'</td>
                                    <td>'.$row['gender'].'</td>
                                    <td>'.$row['verified'].'</td>
                                    <td>
                                    <a href="#" id="'.$row['id'].'" title="View Details" 
                                    class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUsersDetailsModal">
                                    <i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;

                                    <a href="#" id="'.$row['id'].'" title="Delete User" 
                                    class="text-danger deleteUserIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                                    </td>
                                    </tr>';
                    
                    }
                    $output .= ' </tbody>    
                                </table>';
                echo $output;
                   
    }else{
        echo '<h3 class="text-center text-secondary">:( There are no Registered Users Yet!</h3>';
    }
}

//Handle Display Users Details By Id inside Modal Ajax Request
if(isset($_POST['details_id'])){
    $id = $_POST['details_id'];

    $data = $admin->fetchUserDetailsById($id);

    echo json_encode($data);
}

//Handle Delete User Ajax Request
if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];
    $admin->userAction($id,0);
}

//Handle Fetch All Deleted Users Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'fetchAllDeletedUsers'){
    
    $output = '';
    $data = $admin->getRegUser(1);
    $path = '../';

    if($data){
        $output .= '<table class="table table-striped table-bordered text-center tableTwo">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Verified</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        if($row['photo'] != ''){
                            $uphoto = $path.$row['photo'];
                        }else{
                           $uphoto = '../assets/images/avatar.jpeg';
                        }
                        $output .= '<tr>
                                    <td>'.$row['id'].'</td>
                                    <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.$row['phone'].'</td>
                                    <td>'.$row['gender'].'</td>
                                    <td>'.$row['verified'].'</td>
                                    <td>
                                   

                                    <a href="#" id="'.$row['id'].'" title="Restore User" 
                                    class="text-white restoreUserIcon badge badge-dark p-2">Restore</a>
                                    </td>
                                    </tr>';
                    
                    }
                    $output .= ' </tbody>    
                                </table>';
                echo $output;
                   
    }else{
        echo '<h3 class="text-center text-secondary">:( There are no Deleted Users Yet!</h3>';
    }
}

//Handle Restore Deleted User Ajax Request
if(isset($_POST['restore_id'])){
    $id = $_POST['restore_id'];

    $admin->userAction($id,1);
}

//Handle Fetch Notes and Info User Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes'){
    
    $output = '';
    $note = $admin->fetchNotesInfo();
   

    if($note){
        $output .= '<table class="table table-striped table-bordered text-center tableThree">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>User Email</th>
                        <th>Note Title</th>
                        <th>Note Content</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($note as $row){
                        
                        $output .= '<tr>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.$row['title'].'</td>
                                    <td>'.$row['note'].'</td>
                                    <td>'.$row['created_at'].'</td>
                                    <td>'.$row['updated_at'].'</td>
                                    <td>
                                   <a href="#" id="'.$row['id'].'" title="Delete Note" 
                                    class="text-danger deleteNoteIcon"><i class="fas fa-trash-alt fa-lg"></i></a>
                                    </td>
                                    </tr>';
                    
                    }
                    $output .= ' </tbody>    
                                </table>';
                echo $output;
                   
    }else{
        echo '<h3 class="text-center text-secondary">:( There are no Written Notes Yet!</h3>';
    }
}

//Handle Delete Note Ajax Request from dashboard
if(isset($_POST['note_id'])){
    $id = $_POST['note_id'];
    $admin->removeUserNote($id);
}

//Handle Fetch Feedback Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'fetchTotalFeedback'){
    
    $output = '';
    $feedback = $admin->getFeedbackByAdmin();
   

    if($feedback){
        $output .= '<table class="table table-striped table-bordered text-center tableFour">
                    <thead>
                        <tr>
                        <th>FID</th>
                        <th>UID</th>
                        <th>Username</th>
                        <th>User Email</th>
                        <th>Subject</th>
                        <th>Feedback content</th>
                        <th>Sent On</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($feedback as $row){
                        
                        $output .= '<tr>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['uid'].'</td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.$row['subject'].'</td>
                                    <td>'.$row['feedback'].'</td>
                                    <td>'.$row['created_at'].'</td>
                                    <td>
                                   <a href="#"  fid="'.$row['id'].'"  id="'.$row['uid'].'" title="Reply" 
                                    class="text-primary feedbackReplyIcon" data-toggle="modal" data-target="#displayReplyModal">
                                    <i class="fas fa-reply fa-lg"></i></a>
                                    </td>
                                    </tr>';
                    
                    }
                    $output .= ' </tbody>    
                                </table>';
                echo $output;
                   
    }else{
        echo '<h3 class="text-center text-secondary">:( There is no Feedback Sent Yet!</h3>';
    }
}

//Handle Feedback Reply Ajax Request
if(isset($_POST['message'])){
    $uid = $_POST['uid'];
    $message = $admin->test_input($_POST['message']);
    $fid = $_POST['fid'];

    $admin->sendFeedbackReply($uid,$message);
    $admin->repliedStatus($fid);
}

//Handle Fetch Admin Notification Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'getNotification'){

    $notification = $admin->fetchAdNotification();

    $output = '';

    if($notification){
        foreach($notification as $row){
            $output .='<div class="alert alert-dark" role="alert">
                    <button type="button" class="close" id="'.$row['id'].'"data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">New Notification</h4>
                    <p class="mb-0 lead">'.$row['message'].' by '.$row['name'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left"><b>User Email :</b>'.$row['email'].'</p>
                    <p class="mb-0 float-right">'.$admin->timeAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                    </div>';
        }
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary mt-5">There are no new notifications</h3>';
    }
}

//Handle Red Dot Admin Notification Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'alertNotification'){
    if($admin->fetchAdNotification()){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>';
    }else{
        echo '';
    }
}

//Handle Remove Notification Ajax Request
if(isset($_POST['notification_id'])){
    $id = $_POST['notification_id'];
    $admin->removeAdNotification($id);
}



?>