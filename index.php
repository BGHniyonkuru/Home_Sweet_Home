<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Sweet home</title>
  <link rel="stylesheet" type="text/css" href="./Style/style.css">
</head>

<body class="header">
  <h1>Home Sweet Home</h1>

  <h2>Have you ever been homesick about tasty food? Home Sweet Home can solve your problem</h2>

  <header>
    <nav>
      <ul>
        <li><a href="./Contact/contact.html">Contact</a></li>

        <?php
        if (isset($_SESSION["client"]) && $_SESSION["client"] !== false) {
          echo '<li><a href="./deconnexion.php">Log out</a></li>';
          echo '<li><a href="./Articles/panier.php">Basket</a></li>';
          echo '<li><a href="./Articles/historique.php">History</a></li>';
          echo '<li> Bonjour ' . $_SESSION["client"]["prenom"] . ' ' . $_SESSION["client"]["nom"] . '</li>';
        } else {
          echo  '<li><a href="./new_client.php">New client Survey</a></li>';
          echo '<li><a href="./connexion.php">Log in</a></li>';
        }
        ?>
      </ul>
    </nav>
  </header>

  <main>
    <a href="./Articles/article.php?id_art=1">Meal</a>

    <img src="./Images/Home_sweet_home.jpg" alt="Welcome!">
    <img src="./Images/happy_meal.jpg" alt="Meals with your beloved ones">

    <h3>Here are some services we do propose: Food based on ingredients you came with and juicy and delicious drinks. In other terms, happy meals with family or friends.</h3>
    <table>
      <tr>
        <td>item_id</td>
        <td>name</td>
        <td>quantity</td>
        <td>price</td>
        <td>url_photo</td>
        <td>description</td>
      </tr>

      <?php
            include "bd.php";
            $bdd = getBD();
    
            $result = $bdd->query('SELECT url_photo, id_art, nom, quantite, prix FROM articles');
    
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $image = $row['url_photo'];
                $ident = $row['id_art'];
                $nom = $row['nom'];
                $qtt = $row['quantite'];
                $prix = $row['prix'];
                ?>
                <tr>
                    <td><img src="<?php echo $image; ?>" alt="Image du Produit" class="zoom"></td>
                    <td><?php echo $ident; ?></td>
                    <td><?php echo $nom; ?></td>
                    <td><?php echo $qtt; ?></td>
                    <td><?php echo $prix; ?>¥</td>
                    <td><a href="Articles/article.php?id_art=<?php echo $ident; ?>">Voir plus</a></td>
                </tr>
                <?php
            }
        ?>
    </table>

    <p>Home was never near than before!</p>
  </main>

</body>

</html>
