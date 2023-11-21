<?php require "./bd.php";
    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        $n = isset($_POST['n']) ? $_POST['n'] : "";
        $p = isset($_POST['p']) ? $_POST['p'] : "";
        $adr = isset($_POST['adr']) ? $_POST['adr'] : "";  
        $num = isset($_POST['num']) ? $_POST['num'] : "";             
        $mail = isset($_POST['mail']) ? $_POST['mail'] : "";
        $mdp1 = isset($_POST['mdp1']) ? $_POST['mdp1'] : "";
        $mdp2 = isset($_POST['mdp2']) ? $_POST['mdp2'] : "";

        if (!empty($n) && !empty($p) && !empty($adr) && !empty($num) && !empty($mail) && ($mdp1 === $mdp2)) {
        // Les données ne sont pas valides, redirigez vers "new_client.php" avec les données préremplies sauf les mots de passe
            $hashedPassword = password_hash($mdp1, PASSWORD_BCRYPT);

            $bdd = getBD();
            $prepare = "INSERT INTO Clients (nom, prenom, numero, adresse, mail, mdp) VALUES (:nom, :prenom, :numero, :adresse, :mail, :mdp)";
            $stmt = $bdd->prepare($prepare);

            $stmt->bindParam(':nom', $n, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $p, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adr, PDO::PARAM_STR);
            $stmt->bindParam(':numero', $num, PDO::PARAM_STR);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindParam(':mdp', $hashedPassword, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Affichage du message de confirmation
                //echo "Registration succeeded!"; //L'enregistrement des informations dans la BD pas encore effectif
                array=[
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "adresse"=> $adresse,
                    "numero" => $numero,
                    "mail" => $mail,
                    "mdp" => $mdp1,
                ];

                #header("Location: index.php");
                $message = "Registration succeeded";
                exit();
            }else{
                echo "Erreur lors de l'exécution de la requete.";
            }
            else{

            $params = $_POST;
            unset($params['mdp1']);
            unset($params['mdp2']);
            $url = "new_client.php?" . http_build_query($params);
            header("Location: $url");
            $message = "Something went wrong. Try again";
            exit();
    }}

    ?>

<!DOCTYPE html>
    <html lang="en" dir="ltr">
        <head>
            <meta charset="utf-8">
            <title>Enregistrement</title>
            <link rel="stylesheet" type="text/css" href="./Style/style.css">
        </head>
        
        <body>
            
            <?php
            
                if (isset($message)) {
                    echo "<p>$message</p>";
                }
                               
            ?>

        </body>
    </html>