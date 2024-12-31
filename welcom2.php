<?php
session_start();
include("connect.php"); // Inclure la connexion à la base de données

// Vérifier si l'utilisateur est administrateur

// Supprimer un quiz
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM quiz WHERE id = ?";
    $stmt_delete = $com->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();
    header("Location: welcom2.php"); // Rediriger après suppression
    exit();
}

// Modifier un quiz
if (isset($_POST['update_quiz'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $cr = $_POST['cr'];

    $sql_update = "UPDATE quiz SET question = ?, option1 =  ?, option2 = ?, option3 = ?, cr = ? WHERE id = ?";
    $stmt_update = $com->prepare($sql_update);
    $stmt_update->bind_param("ssssii", $question, $option1, $option2, $option3, $cr, $id);
    $stmt_update->execute();
 header("Location: welcom2.php"); // Rediriger après modification
    exit();
}

// Afficher tous les quiz
$sql = "SELECT * FROM quiz";
$res = mysqli_query($com, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quiz</title>
</head>
<style>

     body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(i11.jpg);
            background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
   
     }
        h1 {
            background-color:rgba(60, 63, 66, 0.54);
            color: white;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(214, 218, 223, 0.89);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

              
        button {
            margin-top:10px;
           background-color:rgba(175, 171, 177, 0.69);
            width: 150px;
            padding: 1rem 2rem;
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
          
        button a {
            color: blueviolet;
            text-decoration: none;
        }


        .fr {
            display: none;
            position: fixed;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .fr input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            color:black;
        }

       



    </style>
<body>

<h1>Gestion des Quiz</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Option 1</th>
            <th>Option 2</th>
            <th>Option 3</th>
            <th>Réponse correcte</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['question']; ?></td>
                <td><?php echo $row['option1']; ?></td>
                <td><?php echo $row['option2']; ?></td>
                <td><?php echo $row['option3']; ?></td>
                <td><?php echo $row['cr']; ?></td>
                <td>
                    <button onclick="document.getElementById('editForm<?php echo $row['id']; ?>').style.display='block'">Modifier</button>
                  <button>  <a href="welcom2.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?');">Supprimer</a></button>
               <button ><a href="quiz.html"> Ajouter</a></button>
                </td>
            </tr>

            <div id="editForm<?php echo $row['id']; ?>" style="display:none;" class="fr">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <label>Question:</label>
                    <input type="text" name="question" value="<?php echo $row['question']; ?>" required><br>
                    <label>Option 1:</label>
                    <input type="text" name="option1" value="<?php echo $row['option1']; ?>" required><br>
                    <label>Option 2:</label>
                    <input type="text" name="option2" value="<?php echo $row['option2']; ?>" required><br>
                    <label>Option 3:</label>
                    <input type="text" name="option3" value="<?php echo $row['option3']; ?>" required><br>
                    <label>Réponse correcte:</label>
                    <input type="number" name="cr" value="<?php echo $row['cr']; ?>" required><br>
                    <button type="submit" name="update_quiz">Mettre à jour</button>
                    <button type="button" onclick="document.getElementById('editForm<?php echo $row['id']; ?>').style.display='none'">Annuler</button>
                </form>
            </div>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
