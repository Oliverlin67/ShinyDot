<?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header('Content-Type: application/json; charset=UTF-8');
    
    $userid = $user_info["user_name"];
    $board_id = $_POST["board"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    if($_POST["anonymous"] != 1){
        $_POST["anonymous"] = 0;
    }
    
    if($userid != null){
        if(trim($title) != null){
            if(trim($content) != null && !strpos($content,"<script>")){
                $post = $conn->prepare("INSERT INTO `post` (`userid`,`board_id`,`title`,`content`,`anonymous`) VALUES (?,?,?,?,?)");
                $post->execute(array($userid,$board_id,$title,$content,$_POST["anonymous"]));
            }else{
                $msg = "內容不符合規定";
            }
        }else{
            $msg = "標題不得為空!";
        }
    }
    
    $msg = "發佈成功";
    echo json_encode(array(
        'Msg' => $msg
    ));
}else{
    http_response_code(403);
}