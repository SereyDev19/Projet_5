<?php ob_start(); ?>

    <link href="css/styles-connexion.css" rel="stylesheet">

    <body>
<div id="container">
    <!-- zone de connexion -->

    <form action="admin.php" method="POST">
        <div class="logo">
            <img id="logo" src="../../images/LOGOreportme.png">
        </div>
        <h1>Connexion</h1>

        <label><b>E-mail</b></label>
        <input type="text" placeholder="Entrer votre e-mail" name="email" required>

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrer le mot de passe" name="password" required>

        <input type="submit" id='submit' name='logIn' value='Connexion'>

    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>