<?php
class database
{
    public function __construct()
    {
        
    }
    public function connectDb() {
        //Params to connect to a database
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbName = "webtour";
        //Connect to database
        $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

        if (!$conn) {
            die("Database connection failed!");
        } else {
            //echo "Connected!";
        }
        return $conn;
    }

    
}
?>