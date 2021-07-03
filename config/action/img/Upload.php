<?
header('Content-Type: application/json; charset=UTF-8');
if(isset($_SESSION["user"])){
    if($_FILES['file']['error'] === UPLOAD_ERR_OK){
        $id = base64_encode($file.date("d/H/i/s").substr(md5(uniqid(rand(), true)),0,30));
        
        $file = $_FILES['file']['tmp_name'];
        
        $img_type = end(explode("/",$_FILES['file']["type"]));
        $fileid = $id.".".$img_type;
        move_uploaded_file($file, __DIR__."../../img/upload/".$fileid);
        
        $conn->exec("INSERT INTO `image` (`fileid`,`uploader`) VALUES ('{$fileid}','{$user_info['user_name']}')");
        $msg = '上傳成功:)';
    }else{
        $msg = '發生未知錯誤';
    }
}else{
   $msg = "請先登入";
}
echo json_encode(array(
    'Msg' => $msg,
    'fileid' => $fileid
));