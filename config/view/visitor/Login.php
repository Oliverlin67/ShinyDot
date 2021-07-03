<?
$page_name = "登入";
$page_content = '
<h3 class="text-center">登入帳號</h3>
<form id="login">
    <div class="form-group">
        <label for="user">帳號名稱</label>
        <input type="text" class="form-control" placeholder="帳號名稱" id="user" required>
    </div>
    <div class="form-group">
        <label for="pwd">密碼</label>
        <input type="password" class="form-control" placeholder="密碼" id="pwd" required>
    </div>
    <p>
    <button type="submit" class="btn btn-outline-info btn-block" id="submit">登入</button>
    </p>
    <p class="text-center"><a href="https://forum.coyu.cc/register">還沒有帳號?</a></p>
</form>
';