<?
$html = file_get_contents(__DIR__.'/app.html');
$forum_name = $conn->query("SELECT * FROM `setting` WHERE `name` = 'forum_name'")->fetch(PDO::FETCH_ASSOC)["value"];
$gets = $conn->query("SELECT * FROM `setting` ORDER BY `setting`.`id` DESC");
foreach ($gets as $row) {
    $html = str_replace("{".$row["name"]."}",$row["value"],$html);
}
$html = str_replace("{board_count}",$conn->query("SELECT * FROM `board`")->rowCount(),$html);
$html = str_replace("{main_part}",$page_content,$html);
$html = str_replace("{now_url}",$url[2],$html);
$html = str_replace("{post_id}",$url[2],$html);
$html = str_replace("{share}",'<a class="btn btn-sm btn-light share"><i class="fas fa-share-alt"></i>分享</a>&nbsp;<a class="btn btn-sm btn-light" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={url}">分享到<i class="fab fa-facebook-square"></i></a>',$html);

$boards = $conn->query("SELECT * FROM `board` ");
foreach($boards as $row){
    $boardlist .= '<div class="boardBlock" id="'.$row["board_id"].'"><div class="imgBlock"><img class="rounded-circle" title="'.$row["board_logo"].'" src="https://forum.coyu.cc/ImgShow.php?file='.$row["board_logo"].'" height="30" width="30"/></div><p>'.$row["title"].'</p><i class="fas fa-angle-double-right"></i></div>';
}
$html = str_replace("{board_list}",$boardlist,$html);
$html = str_replace("{url}","https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],$html);

if(!strpos($page,"Edit")){
$accounts = $conn->query("SELECT * FROM `account`");
foreach($accounts as $taguser){
    if($taguser["user_name"] != $user_info["user_name"]){
        $html = str_replace("@".$taguser["user_name"],'<a href="https://forum.coyu.cc/u/'.$taguser["user_name"].'/">@'.$taguser["user_name"].'</a>',$html);
    }
}
}

echo $html;
echo "<title>$page_name | $forum_name</title>";