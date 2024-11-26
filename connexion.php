<?php
include("Connect.php");

$mdp = $_POST['password'];
$email = $_POST['email'];

$sql1 = "SELECT Email FROM membre_site WHERE Email = '$email'";
$res1 = mysqli_query($com, $sql1);

$existe = false;
while ($row = mysqli_fetch_assoc($res1)) {
    if ($email == $row['Email']) {
        $existe = true;
    }
}

if ($existe == true) {
    $test = false;
    $sql2 = "SELECT Password FROM compte WHERE Email = '$email'";
    $res2 = mysqli_query($com, $sql2); // Correction de la variable $res2

    while ($row = mysqli_fetch_assoc($res2)) {
        if ($mdp == $row['Password']) {
            $test = true;
        }
    }

    if ($test == true) {
       include("welcome.html");
    } else {
        
        include("er2.html");

    }
} else {
    include("er3.html");
   
}
?>
