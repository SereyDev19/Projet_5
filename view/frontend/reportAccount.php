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
        <section class="col-xl-12">
            <div class="panel panel-primary">
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
                            <?= $DBaccount['spend30d']; ?> €
                        </td>
                        <td>
                            <?= $DBaccount['leads30d']; ?>
                        </td>
                        <td>
                            <?= $DBaccount['cost_per_lead30d']; ?> €
                        </td>
                    </tr>

                </table>

                <table class="container table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Dépense pub totale</span>
                        </th>

                        <th>
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Nombre de leads ou de ventes total(es)</span>
                        </th>
                        <!--                            <th style="width: 10%">-->
                        <th>
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Coût par lead ou retour sur dépense pub Facebook (totale)</span>
                        </th>

                    </tr>
                    </thead>
                    <tr>
                        <td>
                            <?= $DBaccount['spend30d']; ?> €
                        </td>
                        <td>
                            <?= $DBaccount['leads30d']; ?>
                        </td>
                        <td>
                            <?= $DBaccount['cost_per_lead30d']; ?> €
                        </td>
                    </tr>

                </table>
            </div>
        </section>
    </div>
    <footer class="row col-sm-12">
    </footer>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>