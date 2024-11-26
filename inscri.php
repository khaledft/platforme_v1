<?php 
include ("Connect.php");

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mdp= $_POST['password'];
$email = $_POST['email'];
$date=$_POST['dn'];


$sql1 = "SELECT Email FROM membre_site WHERE Email = '$email'";
$res1 = mysqli_query($com, $sql1);

$existe = false;
while ($row = mysqli_fetch_assoc($res1)) {
    if ($email == $row['Email']) {
        include("erreur.html");
        $existe = true;
    }
}

if (!$existe) {
    // Insertion dans la table compte
    $req2 = "INSERT INTO compte (Email, password) VALUES ('$email', '$mdp')";
    $result_req2 = mysqli_query($com, $req2);

    // Récupération de l'id_compte généré
    $id_compte = mysqli_insert_id($com);

    if ($id_compte) {
        // Insertion dans la table membre_site avec l'id_compte généré
        $sql = "INSERT INTO membre_site (nom, prenom, date_N, filiere, id_compte, Email) VALUES ('$nom', '$prenom', '$date', '$f', $id_compte, '$email')";
        $result_sql = mysqli_query($com, $sql);
        
        if ($result_sql) {
            include("liste.html");

        } else {
            include("erreur.html");
        }
    } else {
        include("erreur.html");
    }
}

?>
