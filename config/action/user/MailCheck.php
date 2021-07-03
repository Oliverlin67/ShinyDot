<?
$page_name = "身分驗證";
if($email != null && $key != null){
    if($conn->query("SELECT * FROM `account` WHERE `profile_mail` = '{$email}' AND `user_status` = '{$key}'")->rowCount() != 0){
        $conn->exec("UPDATE `account` SET `user_status` = 'allow' WHERE `account`.`profile_mail` = '{$email}'");
        $page_content = '<div class="alert alert-success">驗證成功,立即<a href="https://forum.coyu.cc/login">登入</a></div>';
    }else{
        $page_content = '<div class="alert alert-warning">金鑰無效或帳號不存在</div>';
    }
}else{
    $page_content = '<div class="alert alert-warning">value is required</div>';
}