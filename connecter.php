<?php
require("bd.php");

$mailc = isset($_POST['mailc']) ? $_POST['mailc'] : '';
$mdp1c = isset($_POST['mdp1c']) ? $_POST['mdp1c'] : '';

$bdd = getBD();

session_start();

$query = "SELECT * FROM clients WHERE mail = :mail";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':mail', $mailc);
$stmt->execute();
$row = $stmt->fetch();

if ($row) {
    $mdp_hache = $row['mdp'];
    if (password_verify($mdp1c, $mdp_hache)) {
        $_SESSION['client'] = array(
            'id_client' => $row['id_client'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'adresse' => $row['adresse'],
            'numero' => $row['numero'],
            'mail' => $row['mail'],
        );

        $response = array(
            'success' => true,
        
        );
        echo json_encode($response);
    } else {
        $response = array(
            'success' => false,
            'message' => 'Incorrect password',
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'User not found',
    );
    echo json_encode($response);
}
?>
