<?php
include 'include/bdd.php';

session_start();

$bdd = getPDO();

$users = $bdd->prepare("SELECT * FROM user WHERE id = :id");

$users->execute([
    ':id' => $_SESSION['id'],
]);


if ($user = $users->fetch()) {
    if ($user->id_role == 2) {
        $request = $bdd->prepare(
            "SELECT date, type_rdv.type, type_rdv.time, userPro.name, userPro.surname FROM rdvByUser INNER JOIN user ON rdvByUser.idUser = user.id INNER JOIN type_rdv ON rdvByUser.type = type_rdv.id INNER JOIN user as userPro ON rdvByUser.idPro = userPro.id WHERE idUser = :id"
        );
    } else {
        $request = $bdd->prepare(
            "SELECT date, type_rdv.type, type_rdv.time, user.name, user.surname FROM rdvByUser INNER JOIN user ON rdvByUser.idUser = user.id INNER JOIN type_rdv ON rdvByUser.type = type_rdv.id INNER JOIN user as userPro ON rdvByUser.idPro = userPro.id WHERE idPro = :id"
        );
    }
}
$request->execute([
    ':id' => $_SESSION['id'],
]);

$results = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);
header("Content-Type: application/json");
echo $json;
exit();
