
<?php

$host="localhost";
$user="root";
$password="";
$dbname="platforme_quiz";
$dsn = "mysql:host=$host;dbname=$dbname;port=3307;charset=utf8";
try{


    $com=new PDO($dsn,$user,$password);
    $com->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch( PDOException $e){
    echo 'Error : ' . $e->getMessage();
    exit();
}
?>