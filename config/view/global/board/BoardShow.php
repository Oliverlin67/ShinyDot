<?
function getcontent($text){
    $str_r = preg_split('/(?<!^)(?!$)/u', $text);
    for($i=0;$i<80;$i++){
        $str = $str.$str_r[$i];
    }
    return $str;
}
if($board != "all"){
    $boardinfo = $conn->query("SELECT * FROM `board` WHERE `board_id` = '{$board}'");
    if($boardinfo->rowCount() != 0){
        $boardinfo = $boardinfo->fetch(PDO::FETCH_ASSOC);
        $page_name = $boardinfo["title"]."版";
        $tops = $conn->query("SELECT * FROM `post` WHERE `board_id` = '{$board}' AND `align-top` = 1 ORDER BY `id` DESC LIMIT 5");
        if($type == "new"){
            $posts = $conn->query("SELECT * FROM `post` WHERE `board_id` = '{$board}' AND `align-top` = 0 ORDER BY `id` DESC LIMIT 150");
            $ordernew = "selected";
        }else{
            $posts = $conn->query("SELECT * FROM `post` WHERE `board_id` = '{$board}' AND `align-top` = 0 ORDER BY `likeby` DESC LIMIT 150");
            $orderpop = "selected";
        }
        
        $page_content = '
            <div class="card">
            <div style="overflow: hidden;max-height:500px">
                <img title="'.$row["board_logo"].'" src="https://forum.coyu.cc/ImgShow.php?file='.$boardinfo["board_logo"].'" class="card-img-top" alt="'.$row["board_logo"].'">
            </div>
            <div class="card-body">
                <h3>'.$boardinfo["title"].'板</h3>
                <hr>
                <p style="font-size:15px">'.str_replace("\n","<br>",$boardinfo["about"]).'</p>
                <p class="text-right">{share}</p>
            </div>
            </div>
            <hr>
        <div style="margin-bottom:10px;">
        <select class="form-control form-control-sm" id="orderBy">
            <option '.$orderpop.' value="pop">排序依據:熱門</option>
            <option '.$ordernew.' value="new">排序依據:最新</option>
        </select>
        </div>';
        if($posts->rowCount() != 0  || $tops ->rowCount() != 0){
            $page_content .= '<div class="postList">';
            foreach($tops as $top){
                $reply_count = $conn->query("SELECT * FROM `reply` WHERE `postid` = {$top['id']}")->rowCount();
                if($top["anonymous"] == true){
                    $top["postby"] = "匿名";
                }else{
                    $top["postby"] = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$top['userid']}'")->fetch(PDO::FETCH_ASSOC)["profile_nickname"];
                }
                
                $page_content .='<div class="post">
                <a href="https://forum.coyu.cc/p/'.$top["id"].'" style="text-decoration:none;">
                    <article role="article">
                        <p>'.$top["postby"].'</p>
                        <h4>'.$top["title"].'</h4><span class="badge badge-secondary">置頂</span>
                        <div class="postcontent"><small>'.htmlspecialchars(getcontent($top["content"])).'</small></div>
                        <small class="text-danger"><i class="fas fa-heart"></i>&nbsp;'.$top['likeby'].'&nbsp;&nbsp;<span class="text-info"><i class="fas fa-comment-dots"></i>&nbsp;'.$reply_count.'</span></small>
                    </article>
                </a>
                </div>';
            }
            foreach($posts as $post){
                $reply_count = $conn->query("SELECT * FROM `reply` WHERE `postid` = {$post['id']}")->rowCount();
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
                        <small class="text-danger"><i class="fas fa-heart"></i>&nbsp;'.$post['likeby'].'&nbsp;&nbsp;<span class="text-info"><i class="fas fa-comment-dots"></i>&nbsp;'.$reply_count.'</span></small>
                    </article>
                </a>
                </div>';
            }
            $page_content .= '</div><p class="text-info text-center" style="margin:10px 0">已經到列表底部:/</p>';
        }else{
            $page_content .= '<div class="alert alert-info" role="alert">尚無貼文:(</div>';
        }
    }else{
        $page_name = "OPS!發生錯誤了";
        $page_content =  '<div class="text-center"><h3>看板不存在:(</h3><button class="btn btn-info" onclick="history.go(-1);">回上頁</button></div>';
    }
}else{
    $page_name = "全部看板";
    $tops = $conn->query("SELECT * FROM `post` WHERE `align-top` = 1 ORDER BY `id` DESC LIMIT 10");
    if($type == "new"){
        $posts = $conn->query("SELECT * FROM `post` WHERE `align-top` = 0  ORDER BY `id` DESC LIMIT 150");
        $ordernew = "selected";
    }else{
        $posts = $conn->query("SELECT * FROM `post` WHERE `align-top` = 0  ORDER BY `likeby` DESC LIMIT 150");
        $orderpop = "selected";
    }
    $page_content = '<div style="margin-bottom:10px;">
        <select class="form-control form-control-sm" id="orderBy">
            <option '.$orderpop.' value="pop">排序依據:熱門</option>
            <option '.$ordernew.' value="new">排序依據:最新</option>
        </select>
        </div>';
    if($posts->rowCount() != 0 || $tops ->rowCount() != 0){
        $page_content .= '
        <div class="postList">';
        foreach($tops as $top){
            $reply_count = $conn->query("SELECT * FROM `reply` WHERE `postid` = {$top['id']}")->rowCount();
            if($top["anonymous"] == true){
                $top["postby"] = "匿名";
            }else{
                $top["postby"] = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$top['userid']}'")->fetch(PDO::FETCH_ASSOC)["profile_nickname"];
            }
            $board_name = $conn->query("SELECT * FROM `board` WHERE `board_id` = '{$top['board_id']}'")->fetch(PDO::FETCH_ASSOC)["title"];
            $page_content .='<div class="post">
            <a href="https://forum.coyu.cc/p/'.$top["id"].'" style="text-decoration:none;">
                <article role="article">
                    <p>'.$board_name." · ".$top["postby"].'</p>
                    <h4>'.$top["title"].'</h4><span class="badge badge-secondary">置頂</span>
                    <div class="postcontent"><small>'.htmlspecialchars(getcontent($top["content"])).'</small></div>
                    <small class="text-danger"><i class="fas fa-heart"></i>&nbsp;'.$top['likeby'].'&nbsp;&nbsp;<span class="text-info"><i class="fas fa-comment-dots"></i>&nbsp;'.$reply_count.'</span></small>
                </article>
            </a>
            </div>';
        }
        $ad_count = 1;
        foreach($posts as $post){
            $reply_count = $conn->query("SELECT * FROM `reply` WHERE `postid` = {$post['id']}")->rowCount();
            $board_name = $conn->query("SELECT * FROM `board` WHERE `board_id` = '{$post['board_id']}'")->fetch(PDO::FETCH_ASSOC)["title"];
            if($post["anonymous"] == true){
                $post["postby"] = "匿名";
            }else{
                $post["postby"] = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$post['userid']}'")->fetch(PDO::FETCH_ASSOC)["profile_nickname"];
            }
            $post["content"];
            $page_content .='<div class="post">
            <a href="https://forum.coyu.cc/p/'.$post["id"].'" style="text-decoration:none;">
                <article role="article">
                    <p>'.$board_name.' · '.$post["postby"].'</p>
                    <h4>'.$post["title"].'</h4>
                    <div class="postcontent"><small>'.htmlspecialchars(getcontent($post["content"])).'</small></div>
                    <small class="text-danger"><i class="fas fa-heart"></i>&nbsp;'.$post['likeby'].'&nbsp;&nbsp;<span class="text-info"><i class="fas fa-comment-dots"></i>&nbsp;'.$reply_count.'</span></small>
                </article>
            </a>
            </div>';
            $ad_count++;
            if($ad_count == rand(7,21)){
                $page_content .='<ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-gw-3+1f-3d+2z" data-ad-client="ca-pub-6761306742993948" data-ad-slot="3147237397"></ins>';
                $ad_count = 1;
            }
        }
        $page_content .= '</div><p class="text-info text-center" style="margin:10px 0">已經到列表底部:/</p>';
    }else{
        $page_content .= '<div class="alert alert-info" role="alert">尚無貼文:(</div>';
    }
}