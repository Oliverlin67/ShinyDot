<?
if(isset($_SESSION["user"])){
    unset($_SESSION["user"]);
    echo "登出成功";
}