<?
function getcontent($text){
    $str_r = preg_split('/(?<!^)(?!$)/u', $text);
    for($i=0;$i<80;$i++){
        $str = $str.$str_r[$i];
    }
    return $str;
}
$get = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$userid}'");
if($get->rowCount() == 1){
    $get = $get->fetch(PDO::FETCH_ASSOC);
    $page_name = $get["profile_nickname"]."(@{$get['user_name']})的用戶頁面";
    $post_count = $conn->query("SELECT * FROM `post` WHERE `userid` = '{$userid}' AND `anonymous` = '0'")->rowCount();
    $reply_count = $conn->query("SELECT * FROM `reply` WHERE `userid` = '{$userid}' AND `anonymous` = '0'")->rowCount();
    if($get["user_medal"] != null){
        $icons = explode("|",$get["user_medal"]);
        foreach($icons as $icon_name){
            $icon .= '<i class="fas fa-award"></i>'.$icon_name.'&nbsp;&nbsp;';
        }
    }
    if(trim($get["profile_school"]) != null){
        $school = '<li>學校 : '.$get["profile_school"].'</li>';
    }
    if($get["profile_sex"] == "male"){
    	$sex = '<i class="fas fa-mars" style="color:skyblue"></i>';
    }elseif($get["profile_sex"] == "female"){
    	$sex = '<i class="fas fa-venus" style="color:red;"></i>';
    }
    if(trim($get["profile_instagram"]) != null){
        $instagram = '<li><a href="https://instagram.com/'.$get["profile_instagram"].'" target="new">Instagram連結</a></li>';
    }
    $page_content = '<div class="card">
    <div class="card-body">
        <div class="userBlock">
            <h4>'.$get["profile_nickname"].'<small>'.$sex.'</small></h4>
            <small class="text-muted">@'.$get["user_name"].'</small>
            <br>
            <small class="text-muted">'.$icon.'</small>
            <div class="text-center" style="display: flex; flex-direction: row; justify-content: center;height:40px;margin:5px 0">
                <div style="display: flex; flex-direction: column;padding-left: 20px; padding-right: 20px;">
                    <p style="margin:0">'.$post_count.'<br><small>篇公開文章</small></p>
                </div>
                <div style="display: flex; flex-direction: column;padding-left: 20px; padding-right: 20px;border-left: 1px solid black;">
                    <p style="margin:0">'.$reply_count.'<br><small>則公開回應</small></p>
                </div>
            </div>
            <hr>
            <blockquote style="padding: 0 1em;border-left: .25em solid #9c9c9c">
                <p>'.nl2br($get["profile_bio"]).'</p>
            </blockquote>
            <hr>
            <ul>
            <li>生日 : '.date("m月d日", strtotime($get["profile_birthday"])).'</li>
            '.$school.$instagram.'
            </ul>
            <hr>
            <p class="text-right">{share}</p>
    </div>';
    if($userid == $user_info["user_name"]){
        $page_content .= "<hr><p class='text-right'><a href='https://forum.coyu.cc/action/user/logout' class='btn btn-warning btn-sm' style='margin-right:5px;'>登出</a><a href='https://forum.coyu.cc/u/{$userid}/edit' class='btn btn-info btn-sm'>編輯個人檔案</a></p>";
    }
    $page_content .='</div></div><hr><div class="card"><div class="card-header">公開貼文</div><div class="card-body">';
    $posts = $conn->query("SELECT * FROM `post` WHERE `userid` = '{$userid}' AND `anonymous` = 0 ORDER BY `id` DESC LIMIT 150");
    if($posts->rowCount() != 0){
        $page_content .= '
        <div class="postList">';
        foreach($posts as $post){
            $board_name = $conn->query("SELECT * FROM `board` WHERE `board_id` = '{$post['board_id']}'")->fetch(PDO::FETCH_ASSOC)["title"];
            $post["content"];
            $page_content .='<div class="post">
            <a href="https://forum.coyu.cc/p/'.$post["id"].'" style="text-decoration:none;">
                <article role="article">
                    <p>'.$board_name.' · '.$get["profile_nickname"].'</p>
                    <h4>'.$post["title"].'</h4>
                    <div class="postcontent"><small>'.htmlspecialchars(getcontent($post["content"])).'</small></div>
                </article>
            </a>
            </div>';
        }
        $page_content .= '</div><p class="text-info text-center"  style="margin:10px 0">已經到列表底部:/</p>';
    }else{
        $page_content .= '<div class="alert alert-info" role="alert">尚無公開貼文</div>';
    }
    $page_content .= '</div></div>';
}else{
    $page_content = '<div class="text-center"><h3>OPS!用戶ID"'.$userid.'"不見了:(</h3><p>此用戶不存在或被移除了</p><button class="btn btn-success" onclick="history.go(-1);">回上頁</button></div>';
}