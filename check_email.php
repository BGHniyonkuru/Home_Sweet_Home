<?php
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $email = $_POST["email"]?? "";

        $bdd = getBD();
        $prepare = "SELECT COUNT(*) FROM Clients WHERE mail = :email";
        $stmt = $bdd ->prepare($prepare);
        $stmt = bindParam(":email", $email, PDO:PARAM_STR);
        $stmt ->execute();
        $count = $stmt -> fetchColumn();

        echo $count >0 ? "true" : "false";

    }

?>