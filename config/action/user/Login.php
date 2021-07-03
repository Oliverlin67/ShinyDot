<?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header('Content-Type: application/json; charset=UTF-8');
    $user = $_POST["user"];
    $pwd = base64_encode($_POST["pwd"]);
    if($conn->query("SELECT * FROM `account` WHERE `user_name` = '{$user}' AND `user_pwd` = '{$pwd}' AND `user_status` = 'allow'")->rowCount() != 0){
        $get = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$user}'");
        $get = $get->fetch(PDO::FETCH_ASSOC);
        $_SESSION["user"] = 
            json_encode(array(
                'profile_name' => $get["profile_name"],
                'user_name' =>$get["user_name"]
            ),JSON_UNESCAPED_UNICODE);
        $msg = "<div class='alert alert-success'>{$get['profile_name']}同學,歡迎回來</div>";
    }elseif($conn->query("SELECT * FROM `account` WHERE `user_name` = '{$user}' AND `user_pwd` = '{$pwd}' AND `user_status` != 'allow'")->rowCount() != 0){
        $msg = "請先完成信箱驗證";
    }else{
        $msg = "帳號或密碼錯誤";
    }
    echo json_encode(array(
        'Msg' => $msg
    ));
}else{
    http_response_code(403);
}