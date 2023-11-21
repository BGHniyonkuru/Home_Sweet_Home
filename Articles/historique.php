<?php
session_start();

if (isset($_SESSION['client'])) {
    require "../bd.php";
    $bdd = getBD();

    // Récupérez l'identifiant du client connecté
    $id_client = $_SESSION['client']['id_client'];

    // Sélectionnez les commandes du client
    $selectCommandes = "SELECT id_commande, etat_commande FROM Commandes WHERE id_client = :id_client";
    $stmt = $bdd->prepare($selectCommandes);
    $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
    $stmt->execute();

    echo '<table>';
    echo '<tr><th>Commande</th><th>Article</th><th>Prix</th><th>Quantité</th><th>État de la commande</th></tr>';

    while ($commande = $stmt->fetch()) {
        // Récupérez les articles de la commande
        $selectArticles = "SELECT a.id_art, a.nom, a.prix, ac.quantity FROM ArticlesCommandes ac
        JOIN Articles a ON ac.id_art = a.id_art
        WHERE ac.id_commande = :id_commande";
        $stmt2 = $bdd->prepare($selectArticles);
        $stmt2->bindParam(':id_commande', $commande['id_commande'], PDO::PARAM_INT);
        $stmt2->execute();

        while ($article = $stmt2->fetch()) {
            echo '<tr>';
            echo '<td>' . $commande['id_commande'] . '</td>';
            echo '<td>' . $article['nom'] . '</td>';
            echo '<td>' . $article['prix'] . ' €</td>';
            echo '<td>' . $article['quantity'] . '</td>';
            echo '<td>' . $commande['etat_commande'] . '</td>';
            echo '</tr>';
        }
    }

    echo '</table>';
} else {
    echo "Veuillez vous connecter pour voir l'historique de vos commandes.";
}
?>