<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Professionnel</title>

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
                    <form method="post" id="signup-form" class="signup-form">
                        <h2 class="form-title">Contact pour les professionnels</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" for="nom" name="nom" id="nom" placeholder="Entrez votre nom" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" for="prenom" name="prenom" id="prenom" placeholder="Entrez votre prénom" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Entrez votre adresse mail" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-input" name="numTel" id="numTel" placeholder="Entrez votre numéro de téléphone" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" for="sujet" name="sujet" id="sujet" placeholder="Entrez le sujet de votre demande" required>
                        </div>
                        <textarea class="form-input" name="message" id="message" cols="5" rows="4" placeholder="Entrez votre message" required>
                        </textarea>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Envoyer" required />
                        </div>
                    </form>
                    <p class="loginhere" style="margin-top: 45px !important;">
                        Déjà un compte ? <a href="connexion.php" class="loginhere-link">Connectez-vous ici</a>
                    </p>
                </div>
            </div>
        </section>

    </div>
    <?php

    if (isset($_POST["message"])) {
        $message = "Ce message a été envoyé depuis la page de contact pour les professionnels du site GesSan
        Nom : " . $_POST["nom"] . "
        Prenom : " . $_POST["prenom"] . "
        Email : " . $_POST["email"] . "
        Numéro de téléphone : " . $_POST["numTel"] . "
        Message : " . $_POST["message"];

        $retour = mail("contactgessan@gmail.com", $_POST["sujet"], $message, "From: contactpro@gessan.fr");
    };

    ?>

    <!-- JS -->
    <script src="./colorlib-regform-8/vendor/jquery/jquery.min.js"></script>
    <script src="./colorlib-regform-8/js/main.js"></script>
</body>

</html>