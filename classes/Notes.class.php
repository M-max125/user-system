<?php

include_once('Auth.class.php');


class Notes extends Auth{

    //Add New Note

    public function add_new_note($uid,$title,$note){

        $sql = "INSERT INTO notes (uid,title,note) VALUES(:uid,:title,:note)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid,'title'=>$title,'note'=>$note]);
        return true;
    }

    //Fetch All Notes of an User

    public function get_notes($uid){
        $sql = "SELECT * FROM notes WHERE uid = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Edit User Note

    public function edit_note($id){
        $sql = "SELECT * FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Update Note of the User

    public function update_note($id,$title,$note){
        $sql = "UPDATE notes SET title = :title, note = :note, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['title'=>$title,'note'=>$note,'id'=>$id]);

        return true;
    }

    //Delete Note of the User

    public function delete_note($id){
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Update Profile User

    public function update_profile($name,$gender,$dob,$phone,$photo,$id){

        $sql = "UPDATE users SET name = :name, gender = :gender, dob = :dob, phone = :phone, photo = :photo
        WHERE id = :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name'=>$name,'gender'=>$gender,'dob'=>$dob,'phone'=>$phone,'photo'=>$photo,'id'=>$id]);
        return true;
    }

    //Change User Password 

    public function change_password($pass,$id){
        $sql = "UPDATE users SET password = :pass WHERE id = :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass'=>$pass,'id'=>$id]);
        return true;
    }

    //Verify User Email
    public function verify_email($email){
        $sql = "UPDATE users SET verified = 1 WHERE email = :email AND deleted !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        return true;

    }

    //User Send Feedback to Admin
    public function send_feedback($subject,$feedback,$uid){
        $sql = "INSERT INTO feedback (uid,subject,feedback) VALUES (:uid,:subject,:feedback)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid,'subject'=>$subject,'feedback'=>$feedback]);
        return true;
    }

    //Insert Notification

    public function notification($uid,$type,$message){
        $sql = "INSERT INTO notification (uid,type,message) VALUES (:uid,:type,:message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid,'type'=>$type,'message'=>$message]);
        return true;
    }

    //Fetch Notification

    public function fetchNotification($uid){
        $sql = "SELECT * FROM notification WHERE uid = :uid AND type = 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Remove Notification

    public function removeNotification($id){
        $sql = "DELETE FROM notification WHERE id = :id AND type = 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    
}


?>