<?php ob_start(); ?>
<?php $Url = urlencode("http://" . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"]);
require('view/helper.php');
$date = new date();
?>

    <body>
    <div id="dashboard" class="container">
        <header class="row col-sm-12">
            <div>
                <img id="logo" src="../../images/LOGOreportmeWHITE.png">
            </div>
            <div class="page-header">
                <h1>Synthèse : <?= $DBaccount['account_name']; ?></h1>
            </div>
            <div>
                <button class="connect"><a id="deconnexion" href="admin.php?action=logout">Déconnexion</a></button>
            </div>
        </header>
        <div class="row col-sm-12">
            <a class="" href="index.php"><i class="fas fa-arrow-left"></i>Retour vers l'accueil</a>
        </div>
        <div class="btn-group row col-sm-12">
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-home"></i>Aller à
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin.php?action=globalreport">
                        Tous les comptes
                    </a>
                    <a class="dropdown-item" href="admin.php?action=detailedReport&amp;account_id=<?= $accountId; ?>">
                        Rapport détaillé
                    </a>
                </div>
            </div>
        </div>
        <?php if ($userSession->levelAccess != 0): ; ?>
            <button type="button" class="btn btn-info">
                <a href="admin.php?action=updateAccountData&amp;account_id=<?= $accountId; ?>">
                    <i class="fas fa-sync-alt"></i>Mise à jour des données
                </a>
            </button>
        <?php endif; ?>

        <div class="btn-group row col-sm-12 sort">
            <div class="btn-group dropdown col-sm-2 offset-sm-9">
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin.php?action=sortPosts&amp;sort=date&amp;order=ASC">
                        Date <i class="fas fa-sort-up"></i>
                    </a>
                    <a class="dropdown-item" href="admin.php?action=sortPosts&amp;sort=date&amp;order=DESC">
                        Date <i class="fas fa-sort-down"></i>
                    </a>
                    <a class="dropdown-item" href="admin.php?action=sortPosts&amp;sort=postid&amp;order=ASC">
                        Article <i class="fas fa-sort-up"></i>
                    </a>
                    <a class="dropdown-item" href="admin.php?action=sortPosts&amp;sort=postid&amp;order=DESC">
                        Article <i class="fas fa-sort-down"></i>
                    </a>
                </div>
            </div>
        </div>
        <section class="col-xl-6">
            <div class="panel panel-primary">
                <h2>Rapport (30 derniers jours par défaut)</h2>
                <a class="" href="admin.php?action=exportAccountData&amp;account_id=<?= $accountId; ?>"><i
                            class="fas fa-file-csv"></i></a>
                <a href="admin.php?action=exportAccountData&amp;account_id=<?= $accountId; ?>"><i
                            class="far fa-file-pdf"></i></a>
                <table class="container table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Dépense pub Facebook</span>
                        </th>

                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Nombre de leads ou de ventes Facebook</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Coût par lead ou retour sur dépense pub Facebook</span>
                        </th>

                    </tr>
                    </thead>
                    <tr>
                        <td>
                            <span id="plotSpend" class="exportButton"><?= $DBaccount['spend30d']; ?> €</span>
                        </td>
                        <td>
                            <span id="plotLead" class="exportButton"><?= $DBaccount['leads30d']; ?></span>
                        </td>
                        <td>
                            <?= $DBaccount['cost_per_lead30d']; ?> €
                        </td>
                    </tr>

                </table>
            </div>

        </section>

        <section class="col-xl-12">
            <div class="panel panel-primary">
                <section id="plotarea">
<!--                    <h2>Zone graphique</h2>-->
                </section>
            </div>
        </section>
    </div>
    <footer class="row col-sm-12">
    </footer>
    </div>

<?php $content = ob_get_clean(); ?>

<?php ob_start();
if (isset($datesSpend) and isset($valuesSpend)): ; ?>
    <script>
        var app = new App();
        app.init();

        var url = "<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/admin.php?action=testAJAX&account_id=" . $accountId; ?>";

        app.plotSpend('plotSpend');
        app.plotLead('plotLead');
    </script>
<?php endif;
$scripts = ob_get_clean(); ?>

<?php require('template.php'); ?>