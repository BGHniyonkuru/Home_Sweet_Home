<?php session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $mail = $_POST["mail"];
        $mdp =$_POST["mdp"];

        if($mail != "" && $mdp != ""){
            require "./bd.php";
            $bdd = getBD();

            $prepare = "SELECT * FROM clients WHERE mail = :mail AND mdp = :mdp";
  
            $req = $bdd->prepare($prepare);

            $req->execute(array('mail' => $mail, 'mdp' => $mdp));

            

            if ($req -> rowCount() >0 ){
                $user = $req->fetch();

                if(password_verify($mdp, $user["mdp"]))
                $_SESSION['client'] = $user;
                header("Location: ./index.php");
                exit();
            }

            else{
                $error_msg = "Mail adress or password incorrect !";
                header("Location: ./connexion.php");
            }
    }
}
        

    ?>