<?
/*
Controller
*/
session_start();
//include_once __DIR__."../config/sql.php";

$user_info = json_decode($_SESSION["user"],JSON_UNESCAPED_UNICODE);

$url = explode("/",$_SERVER['REQUEST_URI']);
$url[1] = str_replace("index.php?","",$url[1]);

switch($url[1]){
    case "admin":
        /*
        if($conn->query("SELECT * FROM `account` WHERE `user_name` = '{$user_info['user_name']}' AND `user_group` = 'admin'")->rowCount() != 0){
            switch($url[2]){
                case "userList":
                    $page = "view/admin/UserList";
                    break;
                case "postEdit":
                    $page = "view/admin/PostEdit";
                    break;
                case "setting":
                    $page = "view/admin/Setting";
                    break;
                default:
                    $page = "view/admin/Home";
            }
        }else{
            header("Location: https://forum.coyu.cc/b");
        }
        */
        break;
    case "passwordReset":
        //密碼重設
        $page = "view/global/PasswordReset.php";
        break;
    case "search":
        $keyword = urldecode($url[2]);
        $page = "view/global/Search";
        break;
    case "mailCheck":
        //身分驗證
        if(!isset($_SESSION["user"])){
            $email = $url[2];
            $key = $url[3];
            $page = "action/user/MailCheck";
        }else{
            header("Location: https://forum.coyu.cc");
        }
        break;
    case "privacy":
        //隱私權政策
        $page = "view/global/Privacy";
        break;
    case "login":
        //登入
        if(!isset($_SESSION["user"])){
            $page = "view/visitor/Login";
        }else{
            header("Location: https://forum.coyu.cc");
        }
        break;
        
    case "register":
        //註冊
        if(!isset($_SESSION["user"])){
            $page = "view/visitor/Register";
        }else{
            header("Location: https://forum.coyu.cc");
        }
        break;
        
    case "b":
        if($url[2] == null){
            header("Location: https://forum.coyu.cc/b/all");
        }else{
            $board = $url[2];
            if($url[3] == null){
                $type = "pop";
            }elseif($url[3] == "pop"){
                $type = "pop";
            }elseif($url[3] == "new"){
                $type = "new";
            }else{
                header("Location: https://forum.coyu.cc/b/all");
            }
            $page = "view/global/board/BoardShow";
        }

        break;
    case "p":
        if($url[2] != null && $url[2] != "new"){
            //文章
            if($url[3] != "edit"){
                $postid = $url[2];
                $page = "view/global/PostShow";
            }else{
                if(isset($_SESSION["user"])){
                    $page = "view/member/post/Edit";
                }else{
                    //請先登入頁面
                    $page = "view/visitor/Login";
                }
            }
        }else{
            if($url[2] == "new"){
                if(isset($_SESSION["user"])){
                    $page = "view/member/post/Add";
                }else{
                    $page = "view/visitor/Login";
                }
            }else{
                header("Location: https://forum.coyu.cc/b/all");
            }
        }
        
        break;
        
    case "u":
        if($url[2] != null){
            $userid = $url[2];
            if($url[3] != "edit"){
                //用戶
                $page = "view/global/ProfileShow";
            }else{
                $page = "view/member/ProfileEdit";
            }
        }else{
        	if(isset($_SESSION["user"])){
        	    header("Location: https://forum.coyu.cc/u/".$user_info["user_name"]);
            }else{
            	  //請先登入頁面
                $page = "view/visitor/Login";
            }
        }
   
        break;
        
    case "action":
        $_POST = str_replace(["script","SCRIPT"],["blockquote","blockquote"],$_POST);
        switch($url[2]){
            case "imgUpload":
                $page = "action/img/Upload";
                break;
            case "user":
                switch($url[3]){
                    case "login":
                        $page = "action/user/Login";
                        break;
                    case "register":
                        $page = "action/user/Register";
                        break;
                    case "logout":
                        $page = "action/user/Logout";
                        header("Location: https://forum.coyu.cc");
                        break;
                    case "edit":
                        $page = "action/user/EditProfile";
                        break;
                    default:
                        header("Location: https://forum.coyu.cc/b");
                }
                break;
            case "post":
                switch($url[3]){
                    case "add":
                        $page = "action/post/Add";
                        break;
                    case "edit":
                        
                        break;
                    case "del":
                        
                        break;
                    case "report":
                        
                        break;
                    case "reply_like":
                        $page = "action/post/Like_reply";
                        break;
                    case "getinfo":
                        $postid = $url[4];
                        $page = "action/post/GetInfo";
                        break;
                    default:
                        header("Location: https://forum.coyu.cc/b");
                }
                break;
            default:
                header("Location: https://forum.coyu.cc/b");
        }
        break;
    default:
        header("Location: ./b");
}

include_once (__DIR__."/../config/$page.php") or die('view error');
if($url[1] != "action"){
    include_once (__DIR__.'/../config/layout/layout.php') or die('layout master error');
    include_once (__DIR__.'/../config/layout/topbar.php') or die('layout topbar error');
}
