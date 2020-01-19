<?php ob_start(); ?>

<link href="css/styles-connexion.css" rel="stylesheet">
<body>
<div id="container">

    <div id="confirm-message">
        <div class="row col-sm-12">
            <a class="" href="index.php"><i class="fas fa-arrow-left"></i>Retour vers l'accueil</a>
        </div>
        <div class="logo">
            <img id="logo" src="../../images/LOGOreportme.png">
        </div>
        <p>Merci pour votre inscription et bienvenue, <?= $access['access_firstname']; ?>!</p>

    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
