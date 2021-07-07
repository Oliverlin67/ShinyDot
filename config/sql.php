<?
try{
    $conn = new PDO("mysql:host=localhost;dbname=shiny_dot;charset=utf8mb4","shiny_dot","XXXXXXXXXXXXXXXXXXX");
    $conn->setAttribute(PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET time_zone = '+08:00'");
}catch (PDOException $e){
   echo "SQL ERROR: " . $e->getMessage();
}
