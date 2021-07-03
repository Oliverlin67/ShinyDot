<?
$page_name = "新增貼文";
$page_content = '<div class="alert alert-warning">基本發文(進階編輯器尚未完成)</div>
<form id="new_post">
    <div class="form-group">
        <label for="title">標題</label>
        <input type="text" class="form-control" id="title" placeholder="文章標題" required/>
    </div>
    <div class="form-group">
        <label for="content">內容</label>
        <textarea class="form-control" id="content"  placeholder="文章內容" rows="15" required></textarea>
        <p class="text-right" style="margin:10px 0"><a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#uploadModal">插入圖片</a>&nbsp;<a class="btn btn-success btn-sm add_href">插入超連結</a></p>
    </div>
    <div class="form-group">
        <label for="board">看板</label>
        <select class="form-control" id="board" required>
            <option selected disabled>發佈到...看板</option>
            ';
            
$boards = $conn->query("SELECT * FROM `board` ");
foreach($boards as $row){
    $page_content .= '<option value="'.$row["board_id"].'">'.$row["title"].'板</option>';
}
$page_content .=        
'       </select>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" value="1" id="anonymous">
        <label class="form-check-label" for="anonymous">匿名發佈</label>
    </div>
    <button type="submit" class="btn btn-info">發佈</button>
</form>
<br>
<script>
$(".add_href").click(function(){
    $("#content").val($("#content").val() + "<a href=\'要連結的網址\'>顯示的文字</a>");
});
$("#new_post").submit(function(){
    $("#new_post button").html(\'<i class="fa fa-refresh fa-spin"></i>\');
    $("#new_post button").attr("disabled",true);
    if($("#anonymous").prop("checked")){
        var anonymous = 1;
    }else{
        var anonymous = 0;
    }
    $.ajax({
        type:"POST",
        url: "https://forum.coyu.cc/action/post/add",
        dataType: \'json\',
        data: {
            title:$("#title").val(),
            content:$("#content").val(),
            board:$("#board").val(),
            anonymous:anonymous
        },
        success: function (data) {
            if(data.Msg == "發佈成功"){
                $("#new_post").html("<div class=\'alert alert-success\'>" + data.Msg + "</div>");
            }else{
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer)
                        toast.addEventListener("mouseleave", Swal.resumeTimer)
                    }
                });
                Toast.fire({
                  icon: "info",
                  title: data.Msg
                });
                $("#new_post button").html(\'發佈\');
                $("#new_post button").attr("disabled",false);
            }
        }
    });
    return false;
});
</script>';