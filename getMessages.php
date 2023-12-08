<?php
require("bd.php");
$bdd = getBD();

// Vérifiez la connexion


// Récupérez les messages depuis la base de données
$sql =  "SELECT * FROM messages WHERE timestamp > DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY timestamp ";

$result = $bdd->query($sql);

$messages = array();

if ($result) {
    // Utilisez la méthode fetchAll pour récupérer toutes les lignes
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $messages[] = array(
            'id' => $row['id_client'],
            'username' => $row['username'],
            'text' => $row['text'],
            'timestamp' => $row['timestamp']
        );
    }
} else {
    // Gestion des erreurs lors de l'exécution de la requête
    echo "Erreur d'exécution de la requête SQL : " . implode(", ", $bdd->errorInfo());
}
foreach ($messages as $message) {
    $username = $message['username'];
    $text = $message['text'];
    $formatted_message = "$username a dit : \"$text\"";
    echo $formatted_message . "<br>";
}
?>
<?php/*
function setComments(){
    try {
        if(isset($_POST['commentSubmit'])){
            $id_client= $_POST['id_client'];
            $heure= $_POST['heure'];
            $message= $_POST['message'];
    
            $bdd= getBD();
            $query= "INSERT INTO messages (id_client, heure, message) VALUES('$id_client','$heure','$message')";
            $stmt =$bdd->prepare($query);
            $stmt->bindParam(':id_client', $id_client);
            $stmt->bindParam(':heure', $heure);
            $stmt->bindParam(':message', $message);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
}
*/
?>