<?
$page_name = "註冊";
$page_content = '
<form id="register">
    <h3 class="text-center">註冊帳號</h3>
    <div class="form-group">
        <label for="profile_nickname">暱稱(顯示於個人公開檔案)</label>
        <input type="text" class="form-control" placeholder="暱稱" maxlength="30" id="profile_nickname" required>
    </div>
    <div class="form-group">
        <label for="user_name">帳號名稱(登入時使用的名稱)</label>
        <input type="text" class="form-control" placeholder="帳號名稱" id="user_name"  maxlength="50"  onkeyup="value=value.replace(/[^\a-\z\d\._]/g,\'\')" onbeforepaste="clipboardData.setData(\'text\',clipboardData.getData(\'text\').replace(/[^\a-\z\d\._]/g,\'\'))" oncontextmenu="return false" required>
    </div>
    <div class="form-group">
        <label for="user_pwd">密碼(8-50個字元,英數混和)</label>
        <input type="password" class="form-control" placeholder="密碼" id="user_pwd" required>
    </div>
    <hr>
    <div class="form-group">
        <label for="profile_name">真實姓名(用於驗證,不會顯示於個人公開檔案)</label>
        <input type="text" class="form-control" maxlength="4" placeholder="真實姓名" id="profile_name" required>
    </div>
    <div class="form-group">
        <label for="profile_email">學校信箱(用於驗證,<br>註冊後請務必前往學校發之信箱"收件夾"中完成驗證)</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" maxlength="8" placeholder="例:10855001" id="profile_email" onkeyup="value=value.replace(/[^\0-\9]/,\'\')" onbeforepaste="clipboardData.setData(\'text\',clipboardData.getData(\'text\').replace(/[^\0-\9]/,\'\'))" oncontextmenu="return false" aria-label="Student ID" aria-describedby="email-addon" required>
          <div class="input-group-append">
            <span class="input-group-text" id="email-addon">@lsjhs.tp.edu.tw</span>
          </div>
        </div>
    </div>
    <div class="form-group">
        <label for="profile_sex">生理性別</label>
        <select class="form-control" id="profile_sex" required>
            <option selected disabled>請選擇</option>
            <option value="male">男性</option>
            <option value="female">女性</option>
            <option value="other">第三性別</option>
        </select>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="accept" required>
        <label class="form-check-label" for="accept">我閱讀並同意<a target="_blank" href="https://forum.coyu.cc/privacy">隱私權政策</a></label>
    </div>
    <p>
    <button type="submit" class="btn btn-outline-info btn-block" id="submit">註冊</button>
    </p>
    <p class="text-center"><a href="https://forum.coyu.cc/login">已經有帳號?</a></p>
</form>
';

