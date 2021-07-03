<?
$post = $conn->query("SELECT * FROM `post` WHERE `id` = '{$postid}'");
if($post->rowCount() != 0){
    $post = $post->fetch(PDO::FETCH_ASSOC);
    $board_name = $conn->query("SELECT * FROM `board` WHERE `board_id` = '{$post['board_id']}'")->fetch(PDO::FETCH_ASSOC)["title"];
    $page_name = "{$post['title']} -{$board_name}版";
    if($post["anonymous"] == true){
        $post["postby"] = "匿名";
    }else{
        $user = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$post['userid']}'")->fetch(PDO::FETCH_ASSOC);
        if($user["user_medal"] != null){
            $icons = explode("|",$user["user_medal"]);
            foreach($icons as $icon_name){
                $icon .= '&nbsp;&nbsp;<i class="fas fa-award"></i>'.$icon_name;
            }
        }
        $post["postby"] = '<a href="https://forum.coyu.cc/u/'.$post['userid'].'/">'.$user["profile_nickname"].'</a><small class="text-muted">'.$icon."</small>";
    }
    $post["content"] = nl2br($post["content"]);
    $page_content = '<div style="padding-top:30px;">
    <p style="font-size: 18px;line-height: 20px;">
        <i class="fas fa-user-circle"></i>
        <span style="padding-left:3px;margin:0;">'.$post["postby"].'</span>
    </p>
    <h4>'.$post["title"].'</h4>
    <p><small><a href="https://forum.coyu.cc/b/'.$post['board_id'].'">'.$board_name.'</a> · <span class="text-muted">'.date("Y年m月d日 H:i", strtotime($post['time'])).'</span></small></p>
    <p>'.$post["content"].'</p>
    <p class="text-right"><button class="btn btn-sm btn-light text-danger" type="button" id="like_btn"><i class="far fa-heart"></i>獲取中</button>&nbsp;{share}</p>
    </div>
    </div>
    <div class="replyList">
        <h4 style="margin-left:8px">回應</h4>
        <hr>
        <div id="replys">
            [載入中]
        </div>
    </div>
    <div class="fixed-bottom" style="background: rgb(212, 255, 251);padding: .5rem 1rem;">
        <form id="send_reply">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-dark btn-sm" id="anonymous"><i class="fas fa-eye-slash"></i></button>
                </div>
                <input type="text" class="form-control" aria-label="回應" aria-describedby="reply-label" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-dark btn-sm">發送</button>
                </div>
            </div>
        </form>
    </div>
    ';
    
    $page_content .='
    <script>
        var anonymous = true;
        
        setInterval(function(){
            $.get("https://forum.coyu.cc/action/post/reply_like/show/{post_id}",function(data){
                $("#replys").html(data.replys);
                if(data.liked != 0){
                    var icon = "fas";
                }else{
                    var icon = "far";
                }
                $("#like_btn").html(`<i class="${icon} fa-heart"></i>&nbsp;` + data.like);
            });
            console.log("已重新讀取");
        },8000);
        $.get("https://forum.coyu.cc/action/post/reply_like/show/{post_id}",function(data){
            $("#replys").html(data.replys);
            if(data.liked != 0){
                var icon = "fas";
            }else{
                var icon = "far";
            }
            $("#like_btn").html(`<i class="${icon} fa-heart"></i>&nbsp;` + data.like);
        });
        
        const alert = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 800
        });
        
        $("#like_btn").click(function(){
            $("#like_btn").attr("disabled",true);
            $.post("https://forum.coyu.cc/action/post/reply_like/like/{post_id}",function(data){
                if(data.Msg == "請先登入"){
                    alert.fire({
                        icon: "warning",
                        title: data.Msg
                    });
                }
                setTimeout(function(){
                    $.get("https://forum.coyu.cc/action/post/reply_like/show/{post_id}",function(data){
                        if(data.liked != 0){
                            var icon = "fas";
                        }else{
                            var icon = "far";
                        }
                        $("#like_btn").html(`<i class="${icon} fa-heart"></i>&nbsp;` + data.like);
                    });
                    $("#like_btn").attr("disabled",false);
                },100);
            });
        });
        
        $("#send_reply input").keydown(function (event){
            if(event.keyCode == 13){
                event.preventDefault();
                return false;
            }
        });
        
        $("#anonymous").click(function(){
            if($("#anonymous i").attr("class") == "fas fa-eye"){
                $("#anonymous i").attr("class","fas fa-eye-slash");
                anonymous = true;
            }else{
                $("#anonymous i").attr("class","fas fa-eye");
                anonymous = false;
            }
        });
        
        $("#send_reply").submit(function(){
            $("#send_reply button[type=button]").attr("disabled",true);
            $("#send_reply button[type=submit]").attr("disabled",true);
            $.ajax({
                type:"POST",
                url: "https://forum.coyu.cc/action/post/reply_like/reply/{post_id}",
                dataType: "json",
                data: {
                    content:$("#send_reply input").val(),
                    anonymous:anonymous
                },
                success: function (data) {
                    $("html,body").animate({scrollTop:$("#bottom").offset().top},600);
                    alert.fire({
                      icon: "info",
                      title: data.Msg
                    });
                    $("#send_reply")[0].reset();
                    $("#send_reply button[type=submit]").attr("disabled",false);
                    $("#send_reply button[type=button]").attr("disabled",false);
                }
            });
            setTimeout(function(){
                $.get("https://forum.coyu.cc/action/post/reply_like/show/{post_id}",function(data){
                    $("#replys").html(data.replys);
                    if(data.liked != 0){
                        var icon = "fas";
                    }else{
                        var icon = "far";
                    }
                    $("#like_btn").html(`<i class="${icon} fa-heart"></i>&nbsp;` + data.like);
                });
            },100);
            return false;
        });
    </script>
    ';
}else{
    $page_content = '<div class="text-center"><h3>OPS!貼文'.$postid.'似乎披上隱形斗篷:(</h3><p>此篇貼文不存在、被移除了</p><button class="btn btn-success" onclick="history.go(-1);">回上頁</button></div>';
}
