<?php ob_start();
require('view/helper.php');
$date = new date();
?>

    <header class="row col-sm-12">
        <div>
            <img id="logo" src="../../images/LOGOreportmeWHITE.png">
        </div>

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
    </header>


<!--    <div id="content">-->
<!---->
<!--        <div id="main-img" class="row col-sm-12">-->
<!--        </div>-->
<!---->
<!--        <div class="row col-sm-12">-->
<!---->
<!---->
<!--        </div>-->
<!---->
<!--        <div id="main">-->
<!--        </div>-->
<!--    </div>-->


<?php $content = ob_get_clean(); ?>
<?php ob_start();
if (isset($dates) and isset($values)): ; ?>
    <script>
        var app = new App();
        app.init();
        var js_dates = [<?php echo '"' . implode('","', $dates) . '"' ?>];
        var js_values = [<?php echo '"' . implode('","', $values) . '"' ?>];
        app.trace('Dépenses', js_dates, js_values)
    </script>
<?php endif;
$scripts = ob_get_clean(); ?>
<?php require('template.php'); ?>