<?
include_once __DIR__."../config/sql.php";
include_once __DIR__."../vendor/autoload.php";

use GDText\Box;
use GDText\Color;

$filename = $_GET["file"];

if($_GET["file"] != null){
    $type = end(explode('.', $filename));
    if(file_exists(__DIR__."../img/upload/{$filename}")){
        list($w,$h) = getimagesize(__DIR__."../img/upload/{$filename}");
        switch($type){
            case "png":
                $bg = imagecreatefrompng(__DIR__."../img/upload/{$filename}");
                break;
            case "jpg":
                $bg = imagecreatefromjpeg(__DIR__."../img/upload/{$filename}");
                break;
            case "jpeg":
                $bg = imagecreatefromjpeg(__DIR__."../img/upload/{$filename}");
                break;
            case "gif":
                $bg = imagecreatefromgif(__DIR__."../img/upload/{$filename}");
                break;
        }
        
        $im = imagecreatetruecolor($w, $h);
        imagecopy($im,$bg,0,0,0,0,$w,$h);
        
        $box = new Box($im);
        $box->setFontFace(__DIR__."../config/NotoSanstc.ttf");
        $box->setFontSize(40);
        $box->setFontColor(new Color(255, 255, 255,300));
        $box->setBox(0, 0, $w, $h+300);
        $box->setTextAlign('center','center');
        $box->draw("上傳到ShinyDot論壇的圖片\n網站:forum.coyu.cc");
    }else{
        $im = imagecreatetruecolor(500, 300);
        $backgroundColor = imagecolorallocate($im, 212, 255, 251);
        imagefill($im, 0, 0, $backgroundColor);
        $box = new Box($im);
        $box->setFontFace(__DIR__."../config/NotoSanstc.ttf");
        $box->setFontColor(new Color(212, 255, 251));
        $box->setFontSize(30);
        $box->setStrokeColor(new Color(0, 0, 0));
        $box->setStrokeSize(3);
        $box->setBox(0, 0, 500, 300);
        $box->setTextAlign("center","center");
        $box->draw("-Photo Not Found-");
    }
}else{
    $im = imagecreatetruecolor(500, 300);
    $backgroundColor = imagecolorallocate($im, 212, 255, 251);
    imagefill($im, 0, 0, $backgroundColor);
    $box = new Box($im);
    $box->setFontFace(__DIR__."../config/NotoSanstc.ttf");
    $box->setFontColor(new Color(212, 255, 251));
    $box->setFontSize(30);
    $box->setStrokeColor(new Color(0, 0, 0));
    $box->setStrokeSize(3);
    $box->setBox(0, 0, 500, 300);
    $box->setTextAlign("center","center");
    $box->draw("-Photo Not Found-");
}

header('Content-Type: image/webp');
imagewebp($im);
imagedestroy($im);