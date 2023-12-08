<?php
session_start();
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
            
        <?php
            include "../bd.php";
            $bdd = getBD();
            $id_art = isset($_GET['id_art']) ? $_GET['id_art'] : null;

            if ($id_art) {
                $query = $bdd->prepare('SELECT * FROM articles WHERE id_art = :id_art');
                $query->bindParam(':id_art', $id_art, PDO::PARAM_INT);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
            }

            if ($row) {
                $id_art = $row['id_art'];
                $nom = $row['nom'];
                $quantite = $row['quantite'];
                $prix = $row['prix'];
                $url_photo = $row['url_photo'];
                $description = $row['description'];
                $lines = explode("\n", $description);


                $quantite_max = $quantite;

                if (isset($_SESSION['client'])) {
                    $client_id = $_SESSION['client']['id_client'];
                    $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();

                    foreach ($panier as $article) {
                        if ($article['id_art'] == $id_art) {
                            $quantite_panier = $article['quantite'];
                            $quantite_max -=$quantite_panier;
                        }
                    }

                    if (isset($_POST['quantite_article'])) {
                            $quantite_choisie = (int)$_POST['quantite_article'];
                        if ($quantite_choisie > 0 && $quantite_choisie <= $quantite_max) {
                            $_SESSION['quantite_max'][$id_art] = $quantite_choisie;
                        }
                    }
                }
            ?>
                <h1><?php echo $nom; ?></h1>
                <div class="card-container">
                    <img src="<?php echo '../' . $url_photo; ?>" alt="Image de <?php echo $nom; ?>" class="card-image">
                    <ul class="card-detail">
                        <?php for ($i = 0; $i < 4 && $i < count($lines); $i++) {
                            echo "<li>" . $lines[$i] . "</li>";
                        } ?>
                    </ul>
                </div>
                <?php
                if (isset($_SESSION['client'])) {
                ?>
                <form action="ajouter.php" method="POST">
                    <input type="hidden" name="id_art" value="<?php echo $id_art; ?>">
                <input type="number" name="quantite_article" placeholder="Quantité" min="0" max="<?php echo $quantite_max; ?>" value="1">
                    <input type="submit" value="Ajouter l'article">
                </form>
                <?php
                }
                ?>
                <div class="card-price">
                    <p class="price"><?php echo $prix; ?> </p>
                </div>
            <?php
            } else {
                echo "Article introuvable...";
            }
            ?>
                
            <p>Food has never been tasty than the one prepared with ingredients coming straight from home.
                Bring your own ingredients and eat as if you were back home.
            </p>

                
            <p>Soft drinks, healthy drinks for your child and hot ones are just waiting for you.
            We are well prepared for every season just for you.
            </p>

            
    
            <h3>You will go back literally licking your fingers!     
                 And Don't forget to take a little sip you won't regret!</h3>    
        </main>

    </body>
</html>