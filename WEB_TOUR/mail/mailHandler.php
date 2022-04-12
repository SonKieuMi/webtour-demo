<?php
include('class.smtp.php');
include "class.phpmailer.php";
class mailHandler
{
    public function __construct()
    {
    }
    public function sendMail($title, $content, $userName, $emailAddress)
    {
        $nFrom = "Website Du Lich";    //mail duoc gui tu dau, thuong de ten cong ty ban
        $mFrom = 'vie2k2006@gmail.com';  //dia chi email cua ban 
        $mPass = 'tnhv2006@';       //mat khau email cua ban
        $mail             = new PHPMailer();
        $body             = $content;   // Noi dung email
        $title = $title;   //Tieu de gui mail
        $mail->IsSMTP();
        $mail->CharSet  = "utf-8";
        $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;    // enable SMTP authentication
        $mail->SMTPSecure = "ssl";   // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";    // sever gui mail.
        $mail->Port       = 465;         // cong gui mail de nguyen
        // xong phan cau hinh bat dau phan gui mail
        $mail->Username   = $mFrom;  // khai bao dia chi email
        $mail->Password   = $mPass;              // khai bao mat khau
        $mail->SetFrom($mFrom, $nFrom);
        $mail->AddReplyTo('vie2k2006@gmail.com', 'Website Du Lich'); //khi nguoi dung phan hoi se duoc gui den email nay
        $mail->Subject    = $title; // tieu de email 
        $mail->MsgHTML($body); // noi dung chinh cua mail se nam o day.
        $mail->AddAddress($emailAddress, $userName);
        // thuc thi lenh gui mail 
        if ($mail->Send()) {
            return true;
        }
        return false;
    }
}
