<?php ob_start(); ?>

<link href="css/styles-connexion.css" rel="stylesheet">
<body>
<div class="row col-sm-12">
    <a class="text-white" href="index.php"><i class="fas fa-arrow-left"></i>Retour vers l'accueil</a>
</div>
<div id="container">
    <form action="admin.php?action=CreateAccount" method="POST">
        <div class="logo">
            <img id="logo" src="../../images/LOGOreportme.png">
        </div>
        <h1>Nouveau compte</h1>
        <div class="step" id="step1">
            <label><b>Identifiant</b></label>
            <input id="access_id" type="text" placeholder="Identifiant" name="access_id" required>
            <label><b>E-mail</b></label>
            <input id="access_email" type="text" placeholder="E-mail" name="access_email" required>
            <button id="step1Next">Suivant</button>
        </div>

        <div class="step" id="step2">
            <label><b>Nom</b></label>
            <input type="text" placeholder="Nom" name="access_name" required>

            <label><b>Prénom</b></label>
            <input type="text" placeholder="Prénom" name="access_firstname" required>
            <button id="step2Next">Suivant</button>

        </div>

        <div class="step" id="step3">
            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Définir le mot de passe" name="access_password" required>

            <label><b>Confirmer le mot de passe</b></label>
            <input type="password" placeholder="Confirmer le mot de passe" name="confirm_password" required>

            <input type="submit" id='submit' name='signIn' value='Inscription'>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php ob_start();
if (true): ; ?>
    <script>
        var logform = new LogForm();

    </script>
<?php endif;
$scripts = ob_get_clean(); ?>


<?php require('template.php'); ?>
