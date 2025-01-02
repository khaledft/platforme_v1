<?php 
include("connect.php");

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mdp = $_POST['password'];
$email = $_POST['email'];
$date = $_POST['dn'];
$role="user";

try {
    // Préparation de la requête d'insertion
    $sql = "INSERT INTO membre_site (nom, prenom, mdp, email, date,role) VALUES (:nom, :prenom, :mdp, :email, :date,:role)";
    $stmt = $com->prepare($sql);
    
    // Lier les valeurs des variables aux paramètres de la requête
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':role', $role);


    // Exécuter la requête
    if ($stmt->execute()) {
        include("welcom.html");
    } else {
        include("erreur.html");
    }
} catch (PDOException $e) {
    echo 'Error : ' . $e->getMessage();
    exit();
}
?>
