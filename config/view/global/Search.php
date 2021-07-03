<?
function getcontent($text){
    $str =  "";
    $str_r = preg_split('/(?<!^)(?!$)/u', $text);
    for($i=0;$i<80;$i++){
        $str .= $str_r[$i];
    }
    return $str;
}

$page_name = "{$keyword}的搜尋結果";
if(trim($keyword) != null){
    $users = $conn->query("SELECT * FROM `account` WHERE `user_name` like '%{$keyword}%' OR `profile_nickname` like '%{$keyword}%' ORDER BY `id` DESC LIMIT 150");
    if($type == "new"){
        $posts = $conn->query("SELECT * FROM `post` WHERE `content` like '%{$keyword}%' OR `title` like '%{$keyword}%' ORDER BY `id` DESC LIMIT 150");
        $ordernew = "selected";
    }else{
        $posts = $conn->query("SELECT * FROM `post` WHERE `content` like '%{$keyword}%' OR `title` like '%{$keyword}%' ORDER BY `likeby` DESC LIMIT 150");
        $orderpop = "selected";
    }
    $page_content = '
    <form id="search_form">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="輸入關鍵字搜尋" value="'.$keyword.'" aria-describedby="search_form_btn">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="search_form_btn">搜尋<i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>';
    $page_content .= '<h5>文章</h5><hr>';
    if($posts->rowCount() != 0){
        $page_content .= '<div class="postList">';
        foreach($posts as $post){
            if($post["anonymous"] == true){
                $post["postby"] = "匿名";
            }else{
                $post["postby"] = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$post['userid']}'")->fetch(PDO::FETCH_ASSOC)["profile_nickname"];
            }
            $post["content"];
            $page_content .='<div class="post">
            <a href="https://forum.coyu.cc/p/'.$post["id"].'" style="text-decoration:none;">
                <article role="article">
                    <p>'.$post["postby"].'</p>
                    <h4>'.$post["title"].'</h4>
                    <div class="postcontent"><small>'.htmlspecialchars(getcontent($post["content"])).'</small></div>
                </article>
            </a>
            </div>';
        }
        $page_content .= '</div><p class="text-info text-center">已經到列表底部摟</p>';
    }else{
        $page_content .= '<div class="alert alert-info" role="alert">找不到相關文章:(</div>';
    }
    $page_content .= "<hr><h5>用戶</h5><hr>";
    
    
    if($users->rowCount() != 0){
        foreach($users as $user){
            $post["content"];
            $page_content .='<div class="userBlock">
            <a href="https://forum.coyu.cc/u/'.$user["user_name"].'" style="text-decoration:none;">
                <p style="margin-left:8px;" class="text-info">'.$user["profile_nickname"].'(ID: '.$user["user_name"].') >></p>
            </a>
            </div>';
        }
        $page_content .= '<p class="text-info text-center">已經到列表底部摟</p>';
    }else{
        $page_content .= '<div class="alert alert-info" role="alert">找不到相關用戶:(</div>';
    }
}else{
    $page_content = '
    <form id="search_form">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="輸入關鍵字搜尋" value="'.$keyword.'" aria-describedby="search_form_btn">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="search_form_btn">搜尋<i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>';
}