<?php
session_start();
    require("../bd.php");
    $bdd = getBD();
    require_once('../vendor/autoload.php');
    require_once('stripe.php');

    foreach ($_SESSION['panier'] as $article) {
        $id_article = $article['id_art'];
        $quantite = $article['quantite'];

        $requete = 'SELECT id_art, id_stripe, nom, prix FROM articles WHERE :id_art =' . $id_article;
        $resultat = $bdd->prepare($requete);
        $resultat = execute();


        if ($resultat->rowCount() > 0) {
            $row = $resultat->fetch();
            $id_art = $row['id_art'];
            $nom = $row['nom'];
            $prix_unitaire = $row['prix'];
            $id_stripe_prix = $row['id_stripe'];
            $prix_total = $prix_unitaire * $quantite;
            
            $line_items[] = [
                'price' =>$id_stripe_prix,
                'quantity' => $quantite,
            ];
        }
    }
        
        $checkout_session = $stripe->checkout->sessions->create([ 'customer' => $_SESSION['client']['id_stripe'] ,
        'success_url' => 'http://localhost/Home_Sweet_Home/Articles/acheter.php',
        'cancel_url' => 'http://localhost/Home_Sweet_Home/Articles/commande.php',
        'mode' => 'payment' ,
        'automatic_tax' => ['enabled' => false], 
        'line_items' => $line_items,
]);
        header('Location: ' . $checkout_session->url);