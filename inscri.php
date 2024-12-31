<?php 
include ("connect.php");

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mdp= $_POST['password'];
$email = $_POST['email'];
$date=$_POST['dn'];


        $sql = "INSERT INTO membre_site (nom , prenom , mdp , email , date ) VALUES ('$nom' , '$prenom' , '$mdp' , '$email' , '$date');";
        $result_sql = mysqli_query($com, $sql);
        
        if ($result_sql) {
            include("welcom.html");

        } else {
            include("erreur.html");
        }
  


?>
