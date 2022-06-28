<?php
include 'include/bdd.php';

session_start();

$bdd = getPDO();
$request = $bdd->query(
    "SELECT DISTINCT list_rdv.idPro as id, name, surname, type_rdv.type, type_rdv.id as typeID FROM user INNER JOIN list_rdv AS list_rdv ON list_rdv.idPro = user.id  INNER JOIN type_rdv ON type_rdv.id = list_rdv.typeRdv"
);
// $request->execute([
//     ':date' => '2022-06-29 10:00:00'
// ]);


$results = $request->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

header("Content-Type: application/json");
echo $json;
exit();
