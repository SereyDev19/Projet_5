<?php ob_start();
require('view/helper.php');
$date = new date();
?>

    <header class="row col-sm-12">
        <div class="page-header">
            <h1>ReportMe</h1>
        </div>
        <div>
            <img id="logo" src="../../images/LOGOreportmeWHITE.png">
        </div>
    </header>


    <div id="content">
<!--    <h1 id="apptitle">ReportMe</h1>-->
    <div class="tag">
        Tous les indicateurs de performance
    </div>
    <div class="tag">
        en 1 clic
    </div>


    <div id= "main-img" class="row col-sm-12">
    </div>

    <div class="row col-sm-12">
        <div id="connection">
            <?php
            if (isset($_SESSION['user_id']) AND isset($_SESSION['username'])):?>
                <div>
                    <button class="connect"><a href="admin.php">(Connecté)</a></button>
                </div>
                <div>
                    <button class="connect"><a id="deconnexion" href="admin.php?action=logout">Déconnexion</a></button>
                </div>
            <?php
            else:?>
                <div>
                    <button class="connect"><a href="admin.php">Connexion</a></button>
                </div>
                <div>
                    <button class="connect signIn"><a href="admin.php?action=signIn">S'enregistrer</a></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="main">
    </div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>