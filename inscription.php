<?php

session_start();
//Inclusion de la Base de donnée :
include './include/bdd.php';

//Inclusion de la Base de donnée :
$bdd = getPDO();
if (isset($_POST["email"])) {
    if (isset($_POST["mdp1"], $_POST["mdp2"])) {
        // Vérifier si on a inscrit le même mot de passe dans les 2 champs
        $mdp1 = $_POST["mdp1"];
        $mdp2 = $_POST["mdp2"];
        if ($mdp1 == $mdp2) {
            // Cas1 : Les 2 mots de passes sont identiques
            if (isset($_POST["email"], $_POST["nom"], $_POST["prenom"], $_POST["numTel"])) {
                // On récupère tout le reste des données insérés dans le formulaire et on l'insère en BDD
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $email = $_POST["email"];
                $numTel = $_POST["numTel"];
                $mdp = md5($mdp1);
                echo "coucou";


                // On prépare la requete pour insérer le nouveau user en BDD
                $req = "INSERT INTO user(name, surname, phone_number, email,password,id_role)
                    VALUES('$nom', '$prenom', '$numTel', '$email','$mdp', 2)";
                // On exécute la requete pour insérer le nouveau user en BDD
                $Ores = $bdd->query($req);
                //On redirige vers la page de calendrier pour notifier le nouvel user de son inscription
                header('Location: connexion.php');
                exit;
            }
        } else {
            // Cas2 : Les 2 mots de passes ne sont pas identiques
            echo '<script language="Javascript"> alert ("Veuillez renseigner un mot de passe identique dans les 2 champs !" ) </script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>

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
                        <h2 class="form-title">Création du compte</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" for="nom" name="nom" id="nom" placeholder="Entrez votre nom" value="<?php if (isset($_POST['nom'])) {
                                                                                                                                            echo $_POST['nom'];
                                                                                                                                        } ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" for="prenom" name="prenom" id="prenom" placeholder="Entrez votre prénom" value="<?php if (isset($_POST['prenom'])) {
                                                                                                                                                        echo $_POST['prenom'];
                                                                                                                                                    } ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Entrez votre adresse mail" value="<?php if (isset($_POST['email'])) {
                                                                                                                                                echo $_POST['email'];
                                                                                                                                            } ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-input" name="numTel" id="telephone" placeholder="Entrez votre numéro de téléphone" value="<?php if (isset($_POST['numTel'])) {
                                                                                                                                                        echo $_POST['numTel'];
                                                                                                                                                    } ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" for="mdp1" name="mdp1" id="mdp1" placeholder="Entrez un mot de passe" value="<?php if (isset($_POST['mdp1'])) {
                                                                                                                                                        echo $_POST['mdp1'];
                                                                                                                                                    } ?>" required>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" for="mdp2" name="mdp2" id="mdp2" placeholder="Répéter le mot de passe" value="<?php if (isset($_POST['mdp2'])) {
                                                                                                                                                        echo $_POST['mdp2'];
                                                                                                                                                    } ?>" required>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Inscrivez-vous" />
                        </div>
                    </form>
                    <p class="loginhere" style="margin-top: 30px !important;">
                        Professionnel sans accès à la plateforme ? <a href="contactForm.php" class="loginhere-link">Faites une demande ici</a>
                    </p>
                    <p class="loginhere" style="margin-top: 30px !important;">
                        Déjà un compte ? <a href="connexion.php" class="loginhere-link">Connectez-vous ici</a>
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