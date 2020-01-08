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
                <h1>Rapport global</h1>
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
                    <i class="fas fa-home"></i>Actions
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin.php?action=manageAccess">
                        Gérer les accès
                    </a>
                    <a class="dropdown-item" href="admin.php?action=globalreport">
                        Voir les comptes
                    </a>
                </div>
            </div>
        </div>
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
            <table class="container table table-striped table-condensed">
                <thead>
                <tr>
                    <th>
                        <i class="fas fa-wallet"></i>
                        <span class="responsive_title">Compte client</span>
                    </th>
                    <th>
                        <i class="fas fa-chart-area"></i>
                        <span class="responsive_title">Plateforme(s)</span>
                    </th>
                    <th>
                        <i class="far fa-comment-alt"></i>
                        <span class="responsive_title">Autres</span>
                    </th>
                </thead>
                <?php
                foreach ($DBaccounts as $account): ?>
                    <tr>
                        <td>
                            <a href="admin.php?action=reportAccount&amp;account_id=<?=$account['account_id'] ;?>">
                                <?= $account['account_name']; ?>
                                <?= $account['account_id']; ?>
                            </a>

                        </td>
                        <td>
                            <i class="fab fa-facebook-square"></i>
                        </td>
                        <td>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </div>
    <footer class="row col-sm-12">
    </footer>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>