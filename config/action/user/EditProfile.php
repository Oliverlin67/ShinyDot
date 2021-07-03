<?
if($_SERVER['REQUEST_METHOD'] == "POST"){
    header('Content-Type: application/json; charset=UTF-8');
    $profile_nickname = $_POST["profile_nickname"];
    $profile_birthday = $_POST["profile_birthday"];
    $profile_email = $_POST["profile_email"];
    $profile_sex = $_POST["profile_sex"];
    $profile_school = $_POST["profile_school"];
    $profile_instagram = $_POST["profile_instagram"];
    $profile_bio = $_POST["profile_bio"];
    
    $sql = $conn->prepare("UPDATE `account` SET `profile_nickname` = ?,`profile_birthday` = ?,`profile_mail` = ?,`profile_sex` = ?,`profile_school` = ?,`profile_instagram` = ?,`profile_bio` = ? WHERE `user_name` = ?");
    $sql->execute(array($profile_nickname,$profile_birthday,$profile_email,$profile_sex,$profile_school,$profile_instagram,$profile_bio,$user_info["user_name"]));
    
    $msg =  '個人資料已更新';
    echo json_encode(array(
        'Msg' => $msg
    ));
}else{
    http_response_code(403);
}