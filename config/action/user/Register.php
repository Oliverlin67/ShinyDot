<?
require __DIR__.'../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if($_SERVER['REQUEST_METHOD'] == "POST"){

    header('Content-Type: application/json; charset=UTF-8');
    $user_name = strtolower($_POST["user_name"]);
    $user_pwd = base64_encode($_POST["user_pwd"]);
    $profile_name = $_POST["profile_name"];
    $profile_nickname = $_POST["profile_nickname"];
    $profile_email = $_POST["profile_email"];
    $profile_sex = $_POST["profile_sex"];
    $key = substr(md5(uniqid(rand(), true)),0,30);
    
    if(mb_strlen($_POST["user_pwd"])>=8 && mb_strlen($_POST["user_pwd"])<=50 && preg_match("/[0-9]+/",$_POST["user_pwd"]) && preg_match("/[a-z]+/",$_POST["user_pwd"])){
        if($conn->query("SELECT * FROM `account` WHERE `user_studientid` = '{$profile_email}'")->rowCount() != 1 && mb_strlen($profile_email) == 8){
            if($conn->query("SELECT * FROM `account` WHERE `user_name` = '{$user_name}'")->rowCount() != 1){
                $sql = $conn->prepare("INSERT INTO `account` (`user_name`,`user_pwd`,`user_status`,`user_studientid`,`profile_name`,`profile_nickname`,`profile_mail`,`profile_sex`)
                    VALUES (?,?,?,?,?,?,?,?)");
                $sql->execute(array($user_name,$user_pwd,$key,$profile_email,$profile_name,$profile_nickname,"{$profile_email}@lsjhs.tp.edu.tw",$profile_sex));
                
                $mail_content = file_get_contents(__DIR__."../../config/layout/email/emailCheck.html");
                $mail_content = str_replace(["{email}","{key}"],["{$profile_email}@lsjhs.tp.edu.tw",$key],$mail_content);
                
                $mail = new PHPMailer(true);

                //Server settings                      //Enable verbose debug output
                $mail->isSMTP();   //Send using SMTP
                $mail->Charset = 'utf-8';
                $mail->Host       = 'smtp.mailgun.org';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'postmaster@mail.coyu.cc';                     //SMTP username
                $mail->Password   = 'XXXXXXXXXXXXXXXXXXXXXX';                               //SMTP password
                $mail->SMTPSecure = "tls";         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                           //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                //Recipients
                $mail->setFrom('system@mail.coyu.cc', '=?UTF-8?B?' . base64_encode('ShinyDot(閃爍之點)'). '?=');
                $mail->addAddress($profile_email."@lsjhs.tp.edu.tw");     //Add a recipient
                
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = '=?UTF-8?B?' . base64_encode('身分認證 - 最後一步'). '?=';
                $mail->Body    = $mail_content;
                $mail->AltBody = '抱歉,您的裝置不支援HTML';
                
                if($mail->send()){
                    $msg = "註冊成功,請查看您的信箱";
                }else{
                    $msg = "郵件寄送失敗";
                }
            }else{
                $msg = "帳號名稱已被使用";
            }
        }else{
            $msg = "學號已被使用或不符合規則";
        }
    }else{
        $msg = "密碼不符合要求";
    }
    echo json_encode(array(
        'Msg' => $msg
    ));
}else{
    http_response_code(403);
}