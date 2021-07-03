<?
header('Content-Type: application/json; charset=UTF-8');
if($url[4] == "show"){
    $replys = $conn->query("SELECT * FROM `reply` WHERE `postid` = '{$url[5]}' ORDER BY `id` ASC");
    if($replys->rowCount() != 0){
        $id = 1;
        foreach($replys as $row){
            $reply_by = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$row['userid']}'")->fetch(PDO::FETCH_ASSOC);
            if($row["anonymous"] != true){
                $user = '<a href="https://forum.coyu.cc/u/'.$reply_by["user_name"].'">'.$reply_by["profile_nickname"].'</a>';
            }else{
                $user = "匿名";
            }
            
            $reply .= '<div class="replyBlock" id="B'.$id.'">
                <h6><i class="fas fa-user-circle"></i>&nbsp;'.$user.'</h6>
                <small class="text-muted">B'.$id.' · '.date("Y/m/d H:i", strtotime($row['time'])).'</small>
                <p>'.$row["content"].'</p>
            </div><hr>';
            $id++;
        }
    }else{
        $reply .= '<div class="alert alert-info">尚無人回應:(</div>';
    }
    $like = $conn->query("SELECT * FROM `like_post` WHERE `postid` = '{$url[5]}'")->rowCount();
    $liked = $conn->query("SELECT * FROM `like_post` WHERE `postid` = '{$url[5]}' AND `userid` = '{$user_info['user_name']}'")->rowCount();
    echo json_encode(array(
        'replys' => $reply,
        'like' => $like,
        'liked' => $liked
    ));
}elseif($url[4] == "like"){
    if(isset($_SESSION["user"])){
        if($conn->query("SELECT * FROM `like_post` WHERE `postid` = '{$url[5]}' AND `userid` = '{$user_info['user_name']}'")->rowCount() == 0){
            $conn->exec("INSERT INTO `like_post` (`postid`,`userid`) VALUES ('{$url[5]}','{$user_info['user_name']}')");
            $like = ($conn->query("SELECT * FROM `like_post` WHERE `postid` = '{$url[5]}'")->rowCount());
            $conn->exec("UPDATE `post` SET `likeby` = {$like} WHERE `id` = {$url[5]}");
            $msg = "已說讚";
        }else{
            $conn->exec("DELETE FROM `like_post` WHERE `postid` = '{$url[5]}' AND `userid` = '{$user_info['user_name']}'");
            $like = ($conn->query("SELECT * FROM `like_post` WHERE `postid` = '{$url[5]}'")->rowCount());
            $conn->exec("UPDATE `post` SET `likeby` = {$like} WHERE `id` = {$url[5]}");
            $msg = "已收回讚";
        }
    }else{
        $msg = "請先登入";
    }
}elseif($url[4] == "reply"){
    if(isset($_SESSION["user"])){
        if(trim($_POST["content"]) != null){
            if($_POST['anonymous'] == "true"){
                $anonymous = 1;
            }else{
                $anonymous = 0;
            }
            $conn->exec("INSERT INTO `reply` (`postid`,`userid`,`content`,`anonymous`) VALUES ('{$url[5]}','{$user_info['user_name']}','{$_POST['content']}',{$anonymous})");
            $msg = "發佈成功:D";
        }else{
            $msg = "內容不得為空";
        }
    }else{
        $msg = "請先登入";
    }
}

if($url[4] != "show"){
    echo json_encode(array(
        'Msg' => $msg
    ));
}