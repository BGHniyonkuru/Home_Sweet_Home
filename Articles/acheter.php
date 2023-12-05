<?php
session_start();

if (isset($_SESSION['panier'], $_SESSION['totalMontant'], $_SESSION['client'])) {
    require "bd.php";
    $bdd = getBD();

    // Récupérez les informations de la session
    $panier = $_SESSION['panier'];
    $client = $_SESSION['client'];

    // Insérez les informations de la commande dans la table "Commandes"
    $commande = [
        'id_client' => $client['id_client'], // Remplacez par le nom de la colonne correspondante
        'totalMontant' => $_SESSION['totalMontant'],
    ];

    $insertCommande = "INSERT INTO Commandes (id_client, totalMontant) VALUES (:id_client, :totalMontant)";
    $stmt = $bdd->prepare($insertCommande);
    $stmt->execute($commande);

    $commandeID = $bdd->lastInsertId();

    // Mettez à jour les quantités des art
    foreach ($panier as $article) {
        $id_art = $article['id_art'];
        $quantity = $article['quantity'];

        $updateStock = "UPDATE Articles SET quantite = quantite - :quantity WHERE id_art = :id_art";
        $stmt = $bdd->prepare($updateStock);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':id_art', $id_art, PDO::PARAM_INT);
        $stmt->execute();

        // Insérez les articles de la commande dans la table "ArticlesCommandes"
        $insertCommandeArticle = "INSERT INTO ArticlesCommandes (id_commande, id_art, quantity) VALUES (:id_commande, :id_art, :quantity)";
        $stmt = $bdd->prepare($insertCommandeArticle);
        $stmt->bindParam(':id_commande', $commandeID, PDO::PARAM_INT);
        $stmt->bindParam(':id_art', $id_art, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Videz le panier du client en utilisant unset
    unset($_SESSION['panier']);
    unset($_SESSION['totalMontant']);

    echo "Votre commande a bien été enregistrée.";
} else {
    echo "Il semble qu'il y ait un problème avec votre commande.";
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Items</title>
        <link rel="stylesheet" type="text/css" href="../Style/style.css">
    </head>
    
    <body class="header">
        <h1>Home Sweet Home - Items</h1>

        <header>
            <nav>
                <ul>
                    <li><a href="../index.php">Homepage</a></li>
                    <li><a href="../Contact/contact.html">Contact</a></li>
                </ul>
            </nav>
        </header>

        <main>                
                
            <h3>Your order has been successfully registered</h3>    
        </main>

    </body>
</html>