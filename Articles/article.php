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
    
    <body class="groupeX">
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
                
            <p>Food has never been tasty than the one prepared with ingredients coming straight from home.
                Bring your own ingredients and eat as if you were back home.
            </p>

                
            <p>Soft drinks, healthy drinks for your child and hot ones are just waiting for you.
            We are well prepared for every season just for you.
            </p>

                <?php
                    require "../bd.php";
                    $bdd = getBD();
                    $prepare = "SELECT * FROM articles";
                    $rep = $bdd->prepare($prepare);            
                    $rep->execute();
                    $articles = $rep->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($articles as $article) {
                        echo '<h2>' . $article['nom'] . '</h2>';
                        echo '<p> Price : ' . $article['prix'] . ' €</p>';
                        echo '<p> Description : ' . $article['description'] . '</p>';
                        echo '<img src="' . $article['url_photo'] . '" alt="Image de l\'article">';                 
                        }
                    
                        $rep->closeCursor();

                if (isset($_SESSION["client"]) && $_SESSION["client"] !== false){
                ?>
                   

                    <form method="post" action="./ajouter.php" autocomplete="on">

                    Item : <INPUT type="text" name="item" value="" required><br />

                    Quantity : <INPUT type="number" name="quantity" value="" required><br />
            
                    <INPUT type="hidden" name="id_art" value=""><br />

                    <INPUT type="submit" value="Add in your basket"><br />

                    </form>

                <?php
                   }
                ?>
    
            <h3>You will go back literally licking your fingers!     
                 And Don't forget to take a little sip you won't regret!</h3>    
        </main>

    </body>
</html>