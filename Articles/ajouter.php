<?php
session_start();

$id_art = isset($_POST['id_art']) ? $_POST['id_art'] : null;
$quantite_article = isset($_POST['quantite_article']) ? $_POST['quantite_article'] : null;

if ($id_art !== null && $quantite_article !== null) {
    include "../bd.php";
    $bdd = getBD();

    $query = $bdd->prepare('SELECT * FROM articles WHERE id_art = :id_art');
    $query->bindParam(':id_art', $id_art, PDO::PARAM_INT);
    $query->execute();
    $article = $query->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        $quantite_max = $article['quantite'];

        session_start();
        if (isset($_SESSION['client'])) {
            $client_id = $_SESSION['client']['id_client'];
            $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();

            foreach ($panier as $item) {
                if ($item['id_art'] == $id_art) {
                    $quantite_panier = $item['quantite'];
                    $quantite_max = min($quantite_max, $quantite_article - $quantite_panier);
                }
            }

            if (isset($_SESSION['quantite_max'][$id_art])) {
                $quantite_max = min($quantite_max,$_SESSION['quantite_max'][$id_art]);
            }

            if ($quantite_article > 0 && $quantite_article <= $quantite_max) {
                $_SESSION['quantite_max'][$id_art] = $quantite_article;

                $article_existe = false;
                foreach ($_SESSION['panier'] as &$item) {
                    if ($item['id_art'] === $id_art) {
                        $item['quantite'] += $quantite_article;
                        $article_existe = true;
                        break;
                    }
                }

                if (!$article_existe) {
                    $nouvel_article = array(
                        'id_art' => $id_art,
                        'quantite' => $quantite_article
                    );
                    $_SESSION['panier'][] = $nouvel_article;
                }

                header('Location: ../index.php');
                exit();
            } else {
                echo "La quantité choisie n'est pas valide.";
                header('refresh:2;url=index.php');
                exit();
            }
        }
    }
} else {
    echo "Problème avec les données du formulaire.";
}
?>