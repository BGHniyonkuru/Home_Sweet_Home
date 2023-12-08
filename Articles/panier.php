<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Basket</title>
        <link rel="stylesheet" type="text/css" href="../Style/style.css">
        
    </head>

    <body class="header">
        <h1>Home Sweet Home - Basket</h1>

        <header>
            <nav>
                <ul>
                    <li><a href="../index.php">Homepage</a></li>
                    <li><a href="historique.php">History</a></li>
                    <li><a href="../Contact/contact.html">Contact</a></li>
                </ul>
            </nav>
    </header>

    <table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Unity Price (€)</th>
        <th>Quantity</th>
        <th>Total amount (€)</th>
    </tr>
    <?php
    if (isset($_SESSION['panier']) && is_array($_SESSION['panier']) && !empty($_SESSION['panier']) ){
        require "../bd.php";
        $bdd = getBD();
        $totalMontant = 0;
        echo '<h1>Votre Panier</h1>';
            echo '<table border="1">';
            echo '<tr><th>ID Article</th><th>Nom</th><th>Prix unitaire</th><th>Quantité</th><th>Prix total</th></tr>';

        foreach ($_SESSION['panier'] as $ligne) {
            if (is_array($ligne)){
                $id_art = $ligne['id_art']; // L'ID de l'article du panier
                $quantity = $ligne['quantite'];
                $prepare = "SELECT nom, prix FROM articles WHERE id_art = :id_art";
                $rep = $bdd->prepare($prepare);
                $rep->bindParam(':id_art', $id_art, PDO::PARAM_INT);
                
                $rep->execute();
                $articleInfo = $rep->fetch();

                $prixTotal = $articleInfo["prix"] * $quantity; // Calcul du montant total pour cet article

                // Affichez chaque ligne du tableau
                echo "<tr>";
                echo "<td>" . $id_art . "</td>\n";
                echo "<td>" . $articleInfo['nom'] . "</td>\n";
                echo "<td>" . $articleInfo['prix'] . "</td>\n";
                echo "<td>" . $quantity . "</td>\n";
                echo "<td>" . $prixTotal . "</td>\n";
                echo "</tr>";
                $totalMontant += $prixTotal; // Mettez à jour le montant total de la commande
            }
        }
            // Affichez le montant total de la commande

            echo "<tr>";
            echo "<td colspan = '4'>Total Amount</td>";
            echo "<td>" . $totalMontant. "€"."</td>";
            echo "</tr>";


    }
    else{
        echo "<tr><td colspan = '5'> Your basket is emty.</td></tr>";
    }
    ?>
</table>

<a href="commande.php"><button> Passer commande</button></a>
    </body>
</html>