<?php
require_once(dirname(__DIR__)."/core/database.php");
function getInfoUser(string $email){
    $pdo = connexionDB();
    $sql = "
        SELECT u.*,r.* ,a.annee_interval FROM utilisateurs u
        INNER JOIN roles r 
        ON r.id = u.role_id INNER JOIN evaluations ev
        ON u.id = ev.utilisateur_id  INNER JOIN inscriptions i ON i.id = ev.inscription_id INNER JOIN anneScolaires a 
        ON a.id = i.anne_scolaire_id
        WHERE u.email = :email ANd a.actif = 1";
    $query = executeQuery($pdo, $sql, ['email'=>$email]);
    $pdo = null;
    return $query;
}