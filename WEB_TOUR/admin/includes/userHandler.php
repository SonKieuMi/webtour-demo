<?php
require_once "database.php";
class userHandler{
    var $connect;
    public function __construct()
    {

    }
 
    public function login($username,$password){
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if($connect){
            $password = md5($password);
            $sql= "SELECT * FROM user WHERE username = '" .$username."' and password ='" .$password."'";
            $result = mysqli_query($connect,$sql);          
        }else {
            echo("connect failed");
        }
        
        mysqli_close($connect);
        return $result;
    }
}
?>

    