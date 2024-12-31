<?php
include("connect.php");

$mdp = $_POST['password'];
$email = $_POST['email'];

$sql1 = "SELECT email, role FROM membre_site WHERE email = '$email'";
$res1 = mysqli_query($com, $sql1);

$existe = false;
$role = ''; // Variable pour stocker le rôle

while ($row = mysqli_fetch_assoc($res1)) {
    if ($email == $row['email']) {
        $existe = true;
        $role = $row['role']; // Récupérer le rôle de l'utilisateur
    }
}

if ($existe == true) {
    $test = false;
    $sql2 = "SELECT mdp FROM membre_site WHERE email = '$email'";
    $res2 = mysqli_query($com, $sql2);

    while ($row = mysqli_fetch_assoc($res2)) {
        if ($mdp == $row['mdp']) {
            $test = true;
        }
    }

    if ($test == true) {
        // Vérifier le rôle et rediriger vers la bonne page
        if ($role == 'admin') {
            header("Location: welcom2.php"); // Remplacez 'nouvelle_page.php' par le nom de la page cible
exit();
            // Page spécifique pour les admins
        } else if ($role == 'user') {
            header("Location: welcom.html"); // Remplacez 'nouvelle_page.php' par le nom de la page cible
exit();// Page spécifique pour les utilisateurs
        }
    } else {
        include("erreur.html"); // Mot de passe incorrect
    }
} else {
    include("erreur.html"); // Email non trouvé
}
?>
