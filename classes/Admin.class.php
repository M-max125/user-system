<?php

include_once('Database.class.php');

class Admin extends Database{

    //Admin Login
    public function admin_login($username,$password){
        $sql = "SELECT username,password FROM admin WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username'=>$username,'password'=>$password]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    //Count Total Numbers of Rows

    public function totalCount($tablename){
        $sql = "SELECT * FROM $tablename";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

        return $count;


    }
    //Count Total Verified/Unverified Users

    public function verifyUsers($status){
        $sql = "SELECT * FROM users WHERE verified = :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status'=>$status]);

        $result = $stmt->rowCount();
        return $result;

    }

    //Gender Percentage

    public function genderPercentage(){
        $sql = "SELECT gender, COUNT(*) AS number FROM users WHERE gender != '' GROUP BY gender";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Verification Percentage

    public function verifiedPercentage(){
        $sql = "SELECT verified, COUNT(*) AS number FROM users GROUP BY verified";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $count;
    }
    
    //Count Website Access

    public function siteAccess(){
        $sql = "SELECT hits FROM visitors";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total;
    }

    //Fetch All Registered Users From Database

    public function getRegUser($val){
        $sql = "SELECT * FROM users WHERE deleted != $val";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['val'=>$val]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Fetch User Details By Id

    public function fetchUserDetailsById($id){
        $sql = "SELECT * FROM users WHERE id= :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    //Delete User By Id

    public function userAction($id,$val){
        $sql = "UPDATE users SET deleted = $val WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }
    //Fetch All Notes and User Info

    public function fetchNotesInfo(){
        $sql = "SELECT notes.id,notes.title,notes.note,notes.created_at,notes.updated_at,users.name,users.email
         FROM notes INNER JOIN users ON notes.uid = users.id";
         $stmt = $this->conn->prepare($sql);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $result;
    }

    //Delete User Note from dashboard by admin

    public function removeUserNote($id){
        $sql = "DELETE FROM notes WHERE id =:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Get Total Feedback by admnin

    public function getFeedbackByAdmin(){
        $sql = "SELECT feedback.id,feedback.subject,feedback.feedback,feedback.created_at,feedback.uid,users.name,users.email 
        FROM feedback INNER JOIN users ON feedback.uid = users.id WHERE replied != 1 ORDER BY feedback.id DESC";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
        
    }
    //Send Reply To User's Feedback
    public function sendFeedbackReply($uid,$message){
        $sql = "INSERT INTO notification (uid,type,message) VALUES(:uid,'user',:message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid,'message'=>$message]);
        return true;
    }

    //Set Feedback Status To Replied

    public function repliedStatus($fid){
        $sql = "UPDATE feedback SET replied = 1 WHERE id = :fid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fid'=>$fid]);
        return true;
    }

    //Fetch Admin Notification

    public function fetchAdNotification(){
        $sql = "SELECT notification.id,notification.message,notification.created_at,users.name,users.email
        FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' 
        ORDER BY notification.id DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    //Remove Admin Notification

    function removeAdNotification($id){
        $sql = "DELETE FROM notification WHERE id = :id AND type = 'admin'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }
}



?>