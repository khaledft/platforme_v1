<?php
include("Connect.php"); // Assurez-vous que le fichier Connect.php contient la connexion à la base de données

// Récupérer les questions de la base de données



$questions = [];

    

try {
    // Préparation de la requête de selection
    $sql = "SELECT id, question, option1, option2, option3, cr FROM quiz";
    $stmt = $com->prepare($sql);
    $stmt->execute();
    
    // Récupérer toutes les lignes du résultat
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
   
    
} catch (PDOException $e) {
    echo 'Error : ' . $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Century Gothic, Arial, sans-serif;
        }

        body {
            padding: 20px;
            background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(i10.jpg);

        }

        header {
            background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5));
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        header ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        header ul li {
            margin: 0 10px;
        }

        header ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 3px;
            transition: 0.3s;
        }

        header ul li a:hover {
            background-color: #fff;
            color: #4a4a7d;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        #quizPreview {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color:rgba(249, 247, 247, 0.7);
        }
#pr{

    max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color:rgba(249, 247, 247, 0.7);
        }
        .question-preview {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color:rgba(38, 35, 35, 0.15);
        }

        .question-preview h3 {
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .question-preview ul {
            list-style: none;
            padding: 0;
        }

        .question-preview ul li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .question-preview ul li input[type="radio"] {
            margin-right: 10px;
        }

        .question-preview ul li label {
            font-size: 1em;
        }

            
        button {
            margin-top:50px;
            margin-left:150px;
           background-color: #bab7bb44;
            width: 30%;
            padding: 1rem 1rem;
            font-weight: 700;
            color: blueviolet;
            cursor: pointer;
            border-radius: 0.5rem;
            border-bottom: 2px solid blueviolet;
            border-right: 2px solid blueviolet;
            border-top: 2px solid white;
            border-left: 2px solid white;
            transition-duration: 1s;
            transition-property: border-top, border-left, border-bottom, border-right,
              box-shadow;
          }
          
          button:hover {
            border-top: 2px solid blueviolet;
            border-left: 2px solid blueviolet;
            border-bottom: 2px solid rgb(238, 103, 238);
            border-right: 2px solid rgb(238, 103, 238);
            box-shadow: rgba(240, 46, 170, 0.4) 5px 5px, rgba(240, 46, 170, 0.3) 10px 10px,
              rgba(240, 46, 170, 0.2) 15px 15px;
          }
          

        #results {
            max-width: 600px;
            margin: 20px auto;
            background-color:rgba(233, 233, 233, 0.8);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            color: #4a4a7d;
        }
    </style>
</head>
<body>
    <header>
        <h1>Quiz</h1>
        <ul>
            <li><a href="index.html">Accueil</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </header>
    <div id="pr">
    <div id="quizPreview"></div>
    <button onclick="submitQuiz()">Soumettre le Quiz</button>
    <div id="results"></div>
    </div>
    <script>
        const questions = <?php echo json_encode($questions); ?>;

        function displayQuestions() {
            const quizPreview = document.getElementById("quizPreview");
            quizPreview.innerHTML = "";

            questions.forEach((q, index) => {
                let optionsHTML = `
                    <ul>
                        ${[q.option1, q.option2, q.option3].map((option, i) => `
                            <li>
                                <input type="radio" name="question${index}" value="${i}" id="q${index}_option${i}">
                                <label for="q${index}_option${i}">${option}</label>
                            </li>
                        `).join("")}
                    </ul>
                `;

                quizPreview.innerHTML += `
                    <div class="question-preview">
                        <h3>${q.question}</h3>
                        ${optionsHTML}
                    </div>
                `;
            });
        }

        function submitQuiz() {
            let resultsHTML = "";
            let allAnswered = true;

            questions.forEach((q, index) => {
    const selectedOption = document.querySelector(`input[name="question${index}"]:checked`);

    if (selectedOption) {
        const answer = selectedOption.value; 
       
        // Pas de parseInt, car q.cr est une chaîne
        if ((parseInt(answer)+1 )== q.cr) {

            resultsHTML += `<p>Question ${index + 1}: Correct ✅</p>`;
        } else {
            resultsHTML += `<p>Question ${index + 1}: Incorrect ❌ (Réponse correcte: ${q.cr})</p>`;
        }
    } else {
        allAnswered = false;
        resultsHTML += `<p>Question ${index + 1}: Non répondue ❌</p>`;
    }
});

           

            if (!allAnswered) {
                resultsHTML += `<p style="color: red;">Veuillez répondre à toutes les questions avant de soumettre le quiz.</p>`;
            }

            document.getElementById("results").innerHTML = resultsHTML;
        }

        displayQuestions();
    </script>
</body>
</html>
