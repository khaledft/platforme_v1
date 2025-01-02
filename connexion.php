<?php
include("connect.php");

// Récupérer les données envoyées via POST
$mdp = $_POST['password'];
$email = $_POST['email'];

try {
    // Préparer la requête pour vérifier si l'email existe dans la base de données
    $sql1 = "SELECT email, role, mdp FROM membre_site WHERE email = :email";
    $stmt1 = $com->prepare($sql1);
    $stmt1->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt1->execute();

    // Vérifier si l'email existe
    if ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        // Vérifier si le mot de passe est correct
        if ($mdp == $row['mdp']) {
            // Vérifier le rôle et rediriger
            if ($row['role'] == 'admin') {
                header("Location: welcom2.php"); // Page spécifique pour les admins
                exit();
            } else if ($row['role'] == 'user') {
                header("Location: welcom.html"); // Page spécifique pour les utilisateurs
                exit();
            }
        } else {
            // Mot de passe incorrect
            include("erreur.html");
        }
    } else {
        // Email non trouvé
        include("erreur.html");
    }
} catch (PDOException $e) {
    // Si une erreur de connexion ou de requête se produit
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>
