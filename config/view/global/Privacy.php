<?
$privacy = $conn->query("SELECT * FROM `setting` WHERE `name` = 'forum_privacy' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$page_name = "隱私權政策";
$page_content = "<h2><strong>隱私權政策</strong></h2>".$privacy["value"]."<p class='text-right'>最後修改日期:".date("Y年m月d日", strtotime($privacy['last_update']))."</p>";