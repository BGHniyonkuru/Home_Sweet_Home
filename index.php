<?php session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Sweet home</title>
    <link rel="stylesheet" type="text/css" href="./Style/style.css">
  </head>


  <body class="groupeXY">
    <h1>Home Sweet Home</h1>

    <h2> Have you ever been homesick about tasty food?
       Home Sweet Home can solve your problem
    </h2>     

        <header>
            <nav>
                <ul>
                    <li><a href="./Contact/contact.html">Contact</a></li>
                    <li><a href="./Articles/article.php">Items</a></li>
                    
                    <?php 
                    if (isset($_SESSION["client"]) && $_SESSION["client"] !== false){
                      echo '<li><a href="./deconnexion.php">Log out</a></li>';
                      echo '<li><a href="./Articles/panier.php">Basket</a></li>';
                      echo '<li><a href="./Articles/historique.php">History</a></li>';
                      echo '<li> Bonjour '.$_SESSION["client"]["prenom"] . ' ' . $_SESSION["client"]["nom"]. '</li>';
                        }

                    else{
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

            <h3>Here are some services we do propose: Food based on ingredients you came with and juicy and delicious drinks.
          In other terms, happy meals with family or friends.</h3>
            <table>
              <tr>
                <th>item_id</th>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>url_photo</th>
                <th>description</th>
              </tr>

              

          <?php require "./bd.php";
          $bdd = getBD();
          $prepare = "SELECT * FROM articles";
          $rep = $bdd->prepare($prepare);

          //L'affichage du tableau à partir de la base de données n'est pas encore effectif dus à quelques erreus
          if (isset($_GET["id_art"]) && ($_GET["id_art"] == "1" || $_GET["id_art"] == "2")) {

            $prepare = "SELECT * FROM articles WHERE id_art = :id_art";
      
            $rep = $bdd->prepare($prepare);

            $rep->bindParam(':id_art', $_GET["id_art"], PDO::PARAM_INT);
            
            if ($rep->execute() && $rep->rowCount() > 0){
            
              while($ligne = $rep ->fetch()){
                echo '<tr>';
                echo '<td>' . $ligne["id_art"]. '</td>';
                echo '<td>' . $ligne["Name"]. '</td>';
                echo '<td>' . $ligne["quantite"]. '</td>';
                echo '<td>' . $ligne["prix"]. '</td>';
                echo '<td>' . $ligne["description"]. '</td>';
                echo '<td><img src="' . $ligne["url_photo"].'" alt=""></td>';
                echo '</tr>';
            }}
            else{
              echo "Error execution of the request.";
            }
          }
        
            $rep->closeCursor();
        ?>

   
            </table>
                        
            <p>Home was never near than before!</p>
        </main>
    
    </body>
</html>