<?php
include 'include/bdd.php';

session_start();
$bdd = getPDO();

$date = $_POST['date'];
$user = $_SESSION['id'];
$professional = $_POST['profesional'];
$a = explode(",", $professional);







$users = $bdd->prepare("SELECT * FROM rdvByUser WHERE idUser = :id");

$users->execute([
    ':id' => $_SESSION['id']
]);

$req = "INSERT INTO rdvByUser(type,date, idPro,comment , idUser,is_validate) VALUES ($a[1],$date,$a[0] , NULL, $user , 0)";

$Ores = $bdd->query($req);

// gerer la recuperation des info via le formulaire 
// $_POST[propriete] pour avoir la valeur
// methode post action nom du fichier php addEvent.php
