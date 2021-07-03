<?
try{
    $conn = new PDO("mysql:host=localhost;dbname=shiny_dot;charset=utf8mb4","shiny_dot","AEch9q%chpeDpki5@ki509qeD0LT00La855^TAE");
    $conn->setAttribute(PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET time_zone = '+08:00'");
}catch (PDOException $e){
   echo "SQL ERROR: " . $e->getMessage();
}