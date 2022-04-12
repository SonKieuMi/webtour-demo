<?php
require_once "database.php";
class userHandler
{
    var $connect;
    public function __construct()
    {
    }
    // dùng để đăng nhập (login.php/ 16)
    public function login($username, $password)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $password = md5($password);
            $sql = "SELECT * FROM user WHERE username = '" . $username . "' and password ='" . $password . "'";
            $result = mysqli_query($connect, $sql);
        } else {
            echo ("connect false!");
        }

        mysqli_close($connect);
        return $result;
    }
    // dùng để đăng ký(sigup.php/27)
    public function signup($fullname, $email, $phone, $username, $password)
    {
        //connect data base 
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        //Kieểm tra kết nối db có thành công hay không?
        if ($connect) {
            $password = md5($password);
            $sql = "INSERT INTO user VALUES (null,'" . $fullname . "','" . $email . "','" . $phone . "','" . $username . "', '" . $password . "','ROLE_USER')";
            echo ($sql);
            if (mysqli_query($connect, $sql)) {
                mysqli_close($connect);
                return true;
            }
            mysqli_close($connect);
        }
        return false;
    }
    //dùng để ktra user co bị trùng hay ko (checkusername.php/ 5 , sigup.php/21)
    public function checkUsername($username)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $sql = "SELECT * FROM user WHERE username = '" . $username . "'";
            $result = mysqli_query($connect, $sql);
        } else {
            echo ("connect false!");
        }
        mysqli_close($connect);
        return $result;
    }
    // dùng để check mail (checkemail.php/ 5)
    public function checkEmail($email)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $sql = "SELECT * FROM user WHERE email = '" . $email . "'";
            $result = mysqli_query($connect, $sql);
        } else {
            echo ("connect false!");
        }
        mysqli_close($connect);
        return $result;
    }
    //
    public function userAccount($userId)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $result = mysqli_query($connect, "SELECT * FROM user WHERE id = " . $userId . "");
        } else {
            echo "Connection failed!";
        }
        mysqli_close($connect);
        return $result;
    }
    //dùng để cập nhật thông tin ng dùng (manage_infor.php/55)
    public function updateAccount($userId, $fullname, $email, $phone)
    {
        $db = new database();
        $connect = $db->connectDb();
        $sql = "UPDATE user SET full_name = '" . $fullname . "', email = '" . $email . "', 
        phone = '" . $phone . "' WHERE user.id =" . $userId;
        $result = 0;
        if ($connect) {
            try {
                mysqli_query($connect, $sql);
                //$result = $connect->insert_id;
                return true;
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            echo 'Failed to connect';
        }
        mysqli_close($connect);
        return false;
    }
    //dùng ktra mat khau dòng 136
    public function checkPass($id, $password)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $password = md5($password);
            $sql = "SELECT * FROM user WHERE id = " . $id;
            $result = mysqli_query($connect, $sql);
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                mysqli_close($connect);
                return true;
            }
            mysqli_close($connect);
            return false;
        }
        return false;
    }
    //dùng để thay đổi mật khẩu(manage_infor.php/39)
    public function changePass($userId, $oldpass, $newpass)
    {
        $sql = "";
        if ($this->checkPass($userId, $oldpass)) {
            $sql = "UPDATE user SET password = '" . md5($newpass) . "' WHERE user.id =" . $userId;
        }
        if ($sql != "") {
            $db = new database();
            $connect = $db->connectDb();
            if ($connect) {
                try {
                    mysqli_query($connect, $sql);
                    //$result = $connect->insert_id;
                    return true;
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            } else {
                echo 'Failed to connect';
            }
            mysqli_close($connect);
            return false;
        }
        return false;
    }
    //dùng để đặt lại mk khi ng dùng quên()
    public function reset($email, $password)
    {
        $db = new database();
        $connect = $db->connectDb();
        $result = null;
        if ($connect) {
            $password = md5($password);
            $sql = "UPDATE user SET password = '" . $password . "' WHERE user.email='" . $email . "'";
            $result = mysqli_query($connect, $sql);
        } else {
            echo ("connect false!");
        }

        mysqli_close($connect);
        return $result;
    }
}
