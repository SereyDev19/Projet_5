<!DOCTYPE html>
<html>
<head>
    <link href="css/styles-connexion.css" rel="stylesheet">
    <!--</head>-->
<body>
<div id="container">
    <!-- zone de connexion -->

    <form action="admin.php?action=CreateAccount" method="POST">
        <h1>Connexion</h1>

        <label><b>Identifiant</b></label>
        <input type="text" placeholder="Identifiant" name="access_id" required>

        <label><b>E-mail</b></label>
        <input type="text" placeholder="E-mail" name="access_email" required>

        <label><b>Nom</b></label>
        <input type="text" placeholder="Nom" name="access_name" required>

        <label><b>Prénom</b></label>
        <input type="text" placeholder="Prénom" name="access_firstname" required>

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Définir le mot de passe" name="access_password" required>

        <input type="submit" id='submit' name='signIn' value='Inscription'>

    </form>
</div>
