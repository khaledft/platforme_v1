<?php

include ("Connect.php");

$question = $_POST['question'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$option3 = $_POST['option3'];
$correctOption = $_POST['correctOption'];

try {
    // Préparer la requête d'insertion avec PDO
    $sql = "INSERT INTO quiz (question, option1, option2, option3, cr) VALUES (:question, :option1, :option2, :option3, :correctOption)";
    $stmt = $com->prepare($sql);

    // Lier les paramètres à la requête
    $stmt->bindParam(':question', $question, PDO::PARAM_STR);
    $stmt->bindParam(':option1', $option1, PDO::PARAM_STR);
    $stmt->bindParam(':option2', $option2, PDO::PARAM_STR);
    $stmt->bindParam(':option3', $option3, PDO::PARAM_STR);
    $stmt->bindParam(':correctOption', $correctOption, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        include("getq.php");  // Si l'insertion est réussie, inclure la page getq.php
    } else {
        include("erreur.html"); // Si l'insertion échoue, afficher une erreur
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage(); // En cas d'erreur avec PDO, afficher l'erreur
}

?>
