<?php
 class Database{

   const USERNAME = 'youremail@gmail.com';//your email adress
   const PASSWORD = 'yourpassword';//your email password
     
    
    private $dsn = "mysql:host=localhost;dbname=db_user_system";
    private $dbuser = "root";
    private $dbpass = "";

    public $conn;

    public function __construct(){
        try{
            $this->conn = new PDO($this->dsn,$this->dbuser,$this->dbpass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }
        catch(PDOException $e){
            echo 'Error : ' .$e->getMessage();
        }

        
    }

    //Checking the input

    public function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
    // Method for displaying success/error messages
    public function showMessage($type,$message){
        return '<div class="alert alert-'.$type.' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong class="text-center">'.$message.'</strong>
                </div>';
    }
    //Display time by using "ago" format

    public function timeAgo($timestamp){
        date_default_timezone_set('Europe/Bucharest');

        $timestamp = strtotime($timestamp)? strtotime($timestamp) : $timestamp;
        $time = time() - $timestamp;

        switch($time){
            case $time <= 60;//Seconds
            return 'Just Now!';
            
            case $time >= 60 && $time < 3600;//Minutes
            return (round($time/60) == 1)? 'a minute ago' : round($time/60).'minutes ago';
            
            case $time >= 3600 && $time < 86400;//Hours
            return (round($time/3600) == 1)? 'an hour ago' : round($time/3600).'hours ago';
            
            case $time >= 86400 && $time < 604800;//Days
            return (round($time/86400) == 1)? 'a day ago' : round($time/86400).'days ago';

            case $time >= 604800 && $time < 2600640;//Weeks
            return (round($time/604800) == 1)? 'a week ago' : round($time/604800).'weeks ago';

            case $time >= 2600640 && $time < 31207680;//Months
            return (round($time/2600640) == 1)? 'a month ago' : round($time/2600640).'months ago';

            case $time >= 31207680;//Years
            return (round($time/31207680) == 1)? 'a year ago' : round($time/31207680).'years ago';
        }


    }
 }



?>