<?php


include ("Connect.php");

$question = $_POST['question'];
$option1 = $_POST['option1'];
$option2= $_POST['option2'];
$option3 = $_POST['option3'];
$correctOption=$_POST['correctOption'];


        $sql = "INSERT INTO quiz (question , option1 , option2 , option3 , cr ) VALUES ('$question' , '$option1' , '$option2' , '$option3' , '$correctOption');";
        $result_sql = mysqli_query($com, $sql);
        
        if ($result_sql) {
            include("getq.php");

        } else {
            include("erreur.html");
        }
  


?>