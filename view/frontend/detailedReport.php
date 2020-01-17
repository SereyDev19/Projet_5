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
                <h1>Rapport détaillé de : <?= $account[0]['account_name']; ?></h1>
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
                    <a class="dropdown-item" href="admin.php?action=reportAccount&amp;account_id=<?= $accountId; ?>">
                        Rapport synthétique
                    </a>
                </div>
            </div>
        </div>
        <?php if ($userSession->levelAccess != 0): ; ?>
            <button type="button" class="btn btn-info">
                <a href="admin.php?action=updateData&amp;account_id=<?= $accountId; ?>">
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
        <section class="col-xl-12">
            <div class="panel panel-primary">
                <h2>Rapport sur les trentes derniers jours</h2>

                <table class="container table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Nom de l'ensemble de publicités</span>
                        </th>

                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Dépenses pub</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">CPM</span>
                        </th>
                        <th>
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Nombre de clics</span>
                        </th>

                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Coût par clic</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Résultats</span>
                        </th>
                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Coût par résultat</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Taux d'achat</span>
                        </th>
                    </tr>
                    </thead>
                    <?php
                    foreach ($adSets as $data): ?>
                        <tr>
                            <td>
                                <?= $data['adset_name']; ?>
                            </td>
                            <td>
                                <?= $data['spend30d']; ?> €
                            </td>
                            <td>
                                <?= $data['cpm30d']; ?>
                            </td>
                            <td>
                                <?= $data['clicks30d']; ?>
                            </td>
                            <td>
                                <?= $data['cost_per_click30d']; ?> €
                            </td>
                            <td>
                                <?= $data['leads30d']; ?> <br/>
                                <?= $data['optimization_goal']; ?>
                            </td>
                            <td>
                                <?= $data['cost_per_lead30d']; ?> €
                            </td>
                            <td>
                                <?= $data['sell_rate30d']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-home"></i>Filtre
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="admin.php?action=allPosts">
                            Toutes les publicités
                        </a>
                        <?php
                        foreach ($adSets as $data): ?>
                            <a class="dropdown-item" href="admin.php?action=allPosts">
                                <?= $data['adset_name']; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <table class="container table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Nom de la publicité</span>
                        </th>

                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Dépenses pub</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">CPM</span>
                        </th>
                        <th>
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Nombre de clics</span>
                        </th>

                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Coût par clic</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Résultats</span>
                        </th>
                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Coût par résultat</span>
                        </th>
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Taux d'achat</span>
                        </th>
                    </tr>
                    </thead>
                    <?php
                    foreach ($adSets as $iterAdSet):
                        foreach ($allAds[$iterAdSet['adset_id']] as $ad): ?>
                            <tr>
                                <td>
                                    <?= $ad['ad_name']; ?>
                                </td>
                                <td>
                                    <?= $ad['spend30d']; ?> €
                                </td>
                                <td>
                                    <?= $ad['cpm30d']; ?>
                                </td>
                                <td>
                                    <?= $ad['clicks30d']; ?>
                                </td>
                                <td>
                                    <?= $ad['cost_per_click30d']; ?> €
                                </td>
                                <td>
                                    <?= $ad['leads30d']; ?> <br/>
                                    <?= $ad['optimization_goal']; ?>
                                </td>
                                <td>
                                    <?= $ad['cost_per_lead30d']; ?> €
                                </td>
                                <td>
                                    <?= $ad['sell_rate30d']; ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    endforeach; ?>
                </table>
            </div>
            <a class="exportButton" href="">Export des données</a>

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
        // app.init();
        var js_dates = [<?php echo '"' . implode('","', $datesSpend) . '"' ?>];
        var js_values = [<?php echo '"' . implode('","', $valuesSpend) . '"' ?>];
        app.trace('Spend','Dépenses', js_dates, js_values)
        var js_dates = [<?php echo '"' . implode('","', $dateslead) . '"' ?>];
        var js_values = [<?php echo '"' . implode('","', $valuesLead) . '"' ?>];
        app.trace('Lead','Dépenses', js_dates, js_values)
    </script>
<?php endif;
$scripts = ob_get_clean(); ?>

<?php require('template.php'); ?>