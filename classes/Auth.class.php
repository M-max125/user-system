<?php


include_once('Database.class.php');

class Auth extends Database{

    //Register new user

    public function register($name,$email,$password){
        $sql = "INSERT INTO users (name,email,password) VALUES (:name,:email,:pass)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":pass",$password);
        $stmt->execute();
        return true;
    }

    //Checking if the user already exists

    public function user_exist($email){
        $sql = "SELECT email FROM users WHERE email = :email LIMIT 1 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    //Checking Existing User
    public function login($email){
        $sql = "SELECT email,password FROM users WHERE email= :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    //Getting details for the current user in session

    public function currentUser($email){
        $sql = "SELECT * FROM users WHERE email = :email AND deleted !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function is_logged_in(){
        if(isset($_SESSION['user'])){
            return true;
        }
    }

    //Logout the user

    public function logout(){
        session_destroy();
        unset($_SESSION['user']);
        return true;
    }
    //Forgot Password Functionality

    public function forgot_password($token,$email){
        $sql = "UPDATE users SET token = :token,token_expire = DATE_ADD(NOW(),INTERVAL 10 MINUTE) WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token'=>$token,'email'=>$email]);

        return true;
    }

    //Reset Password User Auth

    public function reset_pass_auth($email,$token){
        $sql = "SELECT id FROM users WHERE email = :email AND token = :token AND 
        token != '' AND token_expire > NOW() AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email,'token'=>$token]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //Update New Password

    public function update_new_pass($pass,$email){
        $sql = "UPDATE users SET token = '',password = :pass WHERE email = :email AND  deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass'=>$pass,'email'=>$email]);

        return true;
    }
    
    //Website Access

    public function webClick(){
        $sql = "UPDATE visitors SET hits = hits+1 WHERE id = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return true;
    }
}



?>