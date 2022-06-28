<?php
session_start();
//Inclusion de la Base de donnée :
include 'include/bdd.php';

if (isset($_POST["email"])) {
  //Vérification de l'e-mail saisie
  $email = $_POST["email"];
  $bdd = getPDO();
  $req = "SELECT * FROM user WHERE email LIKE '$email'";
  $Ores = $bdd->query($req);
  if ($usr = $Ores->fetch()) {
    // L'email saisie est inscrit en BDD et correspond bien à un user
    if (isset($_POST["mdp"])) {
      //Vérifier si le mot de passe saisie correspond bien au mot de passe de l'user
      $mdpSaisie = $_POST["mdp"];
      $mdp = md5($mdpSaisie);
      $req1 = "SELECT * FROM user WHERE email LIKE '$email' AND password LIKE '$mdp'";
      $Ores1 = $bdd->query($req1);
      if ($usr = $Ores1->fetch()) {
        $_SESSION['id'] = $usr->id;
        $_SESSION['id_role'] = $usr->id_role;
        var_dump($_SESSION);
        // Le mdp saisie est correct et correspond bien à l'email de l'user, on le laisse entrer dans la page de moncompte (profil user) et en insérant son idUser, son nom, son prenom et son email dans la table en_ligne (pour faciliter l'ajout d'appareil) 
        // ON PREPARE LA REQUETE
        header('Location: calendar.php');
        exit;
      } else {
        // Le mdp saisie est incorrect et ne correspond pas à l'email de l'user
        echo '<script language="Javascript"> alert ("Le mot de passe saisie est incorrect ! Veuillez réessayer !" ) </script>';
      }
    }
  } else {
    // L'email saisie n'est pas inscrit en BDD et correspond à aucun user
    echo '<script language="Javascript"> alert ("L\'identifiant saisie est incorrect ! Veuillez réessayer !" ) </script>';
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Connexion</title>

  <!-- Font Icon -->
  <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
  <!-- Main css -->
  <link rel="stylesheet" href="./colorlib-regform-8/css/style.css">
</head>

<body>

  <div class="main">
    <section class="signup">
      <div class="container">
        <div class="signup-content">
          <form method="POST" id="signup-form" class="signup-form">
            <h2 class="form-title">Connexion</h2>
            <div class="form-group">
              <input type="email" class="form-input" name="email" id="email" placeholder="Votre adresse mail" value="<?php if (isset($_POST['email'])) {
                                                                                                                        echo $_POST['email'];
                                                                                                                      } ?>" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-input" name="mdp" id="password" placeholder="Votre mot de passe" value="<?php if (isset($_POST['mdp'])) {
                                                                                                                            echo $_POST['mdp'];
                                                                                                                          } ?>" required>
              <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
            </div>
            <div class="form-group form-group2">
              <input type="submit" name="submit" id="submit" class="form-submit" value="Connexion" />
            </div>
          </form>
          <p class="loginhere">
            Pas encore de compte ? <a href="connexion.html" class="loginhere-link">Inscrivez-vous ici</a>
          </p>
        </div>
      </div>
    </section>

  </div>

  <!-- JS -->
  <script src="./colorlib-regform-8/vendor/jquery/jquery.min.js"></script>
  <script src="./colorlib-regform-8/js/main.js"></script>
</body>

</html>