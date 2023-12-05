<?php
    function getBD(){
        $bdd = new PDO ("mysql:host=localhost;dbname=home_sweet_home;charset=utf8","root","");
        return $bdd;
    }
?>
    