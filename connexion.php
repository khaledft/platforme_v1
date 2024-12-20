<?php
include("Connect.php");

$mdp = $_POST['password'];
$email = $_POST['email'];

$sql1 = "SELECT email FROM membre_site WHERE email = '$email'";
$res1 = mysqli_query($com, $sql1);

$existe = false;
while ($row = mysqli_fetch_assoc($res1)) {
    if ($email == $row['email']) {
        $existe = true;
    }
}

if ($existe == true) {
    $test = false;
    $sql2 = "SELECT mdp FROM membre_site WHERE email = '$email'";
    $res2 = mysqli_query($com, $sql2); // Correction de la variable $res2

    while ($row = mysqli_fetch_assoc($res2)) {
        if ($mdp == $row['mdp']) {
            $test = true;
        }
    }

    if ($test == true) {
       include("welcom.html");
    } else {
        
        include("erreur.html");

    }
} else {
    include("erreur.html");
   
}
?>
