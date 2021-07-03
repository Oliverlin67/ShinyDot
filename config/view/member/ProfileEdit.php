<?
$page_name = "編輯個人檔案";
$get = $conn->query("SELECT * FROM `account` WHERE `user_name` = '{$userid}'");
if($get->rowCount() == 1 && $userid == $user_info["user_name"]){
    $get = $get->fetch(PDO::FETCH_ASSOC);
    if($get["profile_school"] == null){
        $get["profile_school"] = "麗山國中";
    }
    $page_content = '
    <h3>編輯個人檔案</h3>
    <form id="edit_profile">
        <div class="form-group">
            <label for="user_name">帳號名稱</label>
            <input type="text" class="form-control" value="'.$userid.'" id="user_name" disabled>
        </div>
        <div class="form-group">
            <label for="profile_email">電子郵件信箱</label>
            <input type="text" class="form-control" placeholder="電子郵件信箱" id="profile_email" value="'.$get["profile_mail"].'" required>
        </div>
        <hr>
        <h5>公開資料</h5>
        <div class="form-group">
            <label for="profile_bio">個人簡介(顯示於個人檔案上)</label>
            <textarea class="form-control" rows="6" placeholder="個人簡介" id="profile_bio">'.$get["profile_bio"].'</textarea>
        </div>
        <div class="form-group">
            <label for="profile_instagram">Instagram連結(顯示於個人檔案上)</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="Instagram-addon">https://instagram.com/</span>
                </div>
                <input type="text" class="form-control" maxlength="50" value="'.$get["profile_instagram"].'" placeholder="Instagram帳號名稱" id="profile_instagram" onkeyup="value=value.replace(/[^\a-\z\d\._]/g,\'\')" onbeforepaste="clipboardData.setData(\'text\',clipboardData.getData(\'text\').replace(/[^\a-\z\d\._]/g,\'\'))" aria-label="Instagram" aria-describedby="Instagram-addon">
            </div>
        </div>
        <hr>
        <h5>個人基本資料</h5>
        <div class="form-group">
            <label for="profile_nickname">暱稱(顯示於個人檔案上)</label>
            <input type="text" class="form-control" placeholder="暱稱" maxlength="30" value="'.$get["profile_nickname"].'" id="profile_nickname" required>
        </div>
        <div class="form-group">
            <label for="profile_name">真實姓名</label>
            <input type="text" class="form-control" maxlength="4"  value="'.$get["profile_name"].'" id="profile_name" disabled>
        </div>
        <div class="form-group">
            <label for="profile_birthday">出生年月日(將顯示月/日於個人檔案上)</label>
            <input type="date" class="form-control" value="'.$get["profile_birthday"].'" id="profile_birthday">
        </div>
        <div class="form-group">
            <label for="profile_sex">生理性別</label>
            <select class="form-control" id="profile_sex" required>
                <option disabled>請選擇</option>
                <option value="male">男性</option>
                <option value="female">女性</option>
                <option value="other">第三性別</option>
            </select>
        </div>
        <div class="form-group">
            <label for="profile_school">就讀學校(顯示於個人檔案上)</label>
            <select class="form-control" id="profile_school" required>
                <option disabled>請選擇</option>
                <option value="麗山國中">北市麗山國中</option>
                <option value="內湖國中">北市內湖國中</option>
                <option value="其他">其他</option>
            </select>
        </div>
        <hr>
        <button class="btn btn-success" type="submit">儲存變更</button>&nbsp;&nbsp;
        <a href="../" class="btn btn-info">返回</a>
    </form>
    <script>
        $("option[value='.$get["profile_sex"].']").attr("selected","selected");
        $("option[value='.$get["profile_school"].']").attr("selected","selected");
        $("#edit_profile").submit(function(){
            $("#edit_profile button").html("<i class=\'fa fa-refresh fa-spin\'></i>");
            $("#edit_profile button").attr("disabled",true);
            
            const Toast = Swal.mixin({
                toast: true,
                position: \'top\',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener(\'mouseenter\', Swal.stopTimer)
                    toast.addEventListener(\'mouseleave\', Swal.resumeTimer)
                }
            });
            $.ajax({
                type:"POST",
                url: "https://forum.coyu.cc/action/user/edit",
                dataType: "json",
                data: {
                    profile_bio:$("#profile_bio").val(),
                    profile_instagram:$("#profile_instagram").val(),
                    profile_nickname:$("#profile_nickname").val(),
                    profile_birthday:$("#profile_birthday").val(),
                    profile_email:$("#profile_email").val(),
                    profile_sex:$("#profile_sex").val(),
                    profile_school:$("#profile_school").val()
                },
                success: function (data) {
                    Toast.fire({
                      icon: "info",
                      title: data.Msg
                    });
                    $("#edit_profile button").html(\'儲存變更\');
                    $("#edit_profile button").attr("disabled",false);
                }
            });
            return false;
        });
    </script>
    ';
}else{
    header("Location: https://forum.coyu.cc/");
}