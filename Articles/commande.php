<?php
    session_start();

    if (!isset($_SESSION['panier'], $_SESSION['totalMontant'], $_SESSION['client'])) {
        // Redirigez l'utilisateur vers une autre page s'il manque des données
        header("Location: panier.php"); // Remplacez "page_precedente.php" par la page appropriée
        exit();
    }
    
    // Récupérez les informations de la session
    $panier = $_SESSION['panier'];
    $totalMontant = $_SESSION['totalMontant'];
    $client = $_SESSION['client'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order</title>
        <link rel="stylesheet" type="text/css" href="./Style/style.css">
        
    </head>

    <body class="groupeXY">
        <h1>Home Sweet Home - Order</h1>

        <header>
            <nav>
                <ul>
                    <li><a href="../index.php">Homepage</a></li>
                    <li><a href="./panier.php">Basket</a></li>
                    <li><a href="../Contact/contact.html">Contact</a></li>
                </ul>
            </nav>
    </header>

    <h2>Order summary</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
        </tr>
        <?php
        // Affichez les articles du panier avec les quantités
        foreach ($panier as $article) {
            echo "<tr>";
            echo "<td>{$article['Name']}</td>";
            echo "<td>{$article['Quantity']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <p>Total amount : <?php echo $totalMontant; ?> €</p>

    <p>The delivery will take place at:</p>
    <p>Client name : <?php echo $client['nom']; ?></p>
    <p>Client firstname : <?php echo $client['prenom']; ?></p>
    <p>Adress : <?php echo $client['adresse']; ?></p>

    <form action="acheter.php" method="post">

    <input type="submit" value="Validate">

    </form>



    </body>
</html>