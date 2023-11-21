<?php
session_start();

if (!isset($_SESSION["panier"])) {
    $_SESSION["panier"] = array();
}

if (!empty($_POST['quantity'])) {
    $quantity = $_POST["quantity"];
    $id_art = $_POST["id_art"];

    // Ajoutez un tableau associatif au panier
    $article = array('id_art' => $id_art, 'quantity' => $quantity);
    $_SESSION["panier"][] = $article;
}

header("Location: ../index.php");
exit();
?>
