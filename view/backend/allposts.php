<?php ob_start(); ?>
<?php $Url = urlencode("http://" . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"]);
require('view/helper.php');
$date = new date();
?>

<body>
    <div id="dashboard" class="container">
        <header class="row col-sm-12">
            <div class="page-header">
                <h1>Tableau de bord</h1>
                <h2 class="white">Tous les articles</h2>
            </div>
        </header>
        <div class="row col-sm-12">
            <a class="" href="index.php"><i class="fas fa-arrow-left"></i>Retour vers le blog</a>
        </div>
        <div class="btn-group row col-sm-12">
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-home"></i>Articles
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin.php?action=allPosts">
                        Tous les articles
                    </a>
                    <a class="dropdown-item" href="admin.php?action=newPost">
                        Nouvel article
                    </a>
                </div>
            </div>
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-list-alt"></i>
                    Commentaires
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin.php?action=allComments&amp;reported=false">
                        Tous les commentaires
                    </a>
                    <a class="dropdown-item" href="admin.php?action=allComments&amp;reported=true">
                        Commentaires signalés
                        <?php if ($notification['new_notifications'] == 1):; ?>
                            <i class="fas fa-exclamation-circle"></i>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary">
                    <a class="nav-link" href="admin.php?action=logout"><i
                                class="fas fa-sign-out-alt"></i>Déconnexion</a>
                </button>
            </div>
        </div>
        <div class="btn-group row col-sm-12 sort">
            <div class="btn-group dropdown col-sm-2 offset-sm-9">
                <button id="sort" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-list-alt"></i>
                    Trier par :
                </button>
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
                <div>
                    <table class="container table table-striped table-condensed">
                        <thead>
                        <tr>
<!--                            <th style="width: 10%">-->
                            <th>
                                <i class="far fa-calendar-alt"></i>
                                <span class="responsive_title">Date de création</span>
                            </th>
<!--                            <th style="width: 10%">-->
<!--                                <i class="fas fa-calendar-plus"></i>-->
<!--                                <span class="responsive_title">Date de modification</span>-->
<!--                            </th>-->
<!--                            <th style="width: 10%" class="postTitle">-->
                            <th>
                                <i class="far fa-newspaper"></i>
                                <span class="responsive_title">Article</span>
                            </th>
<!--                            <th style="width: 10%">-->
                            <th>
                                <i class="far fa-comment-alt"></i>
                                <span class="responsive_title">Commentaires</span>
                            </th>
<!--                            <th colspan="3" style="width: 15%" style="action">-->
                            <th colspan="3" style="action">
                                <i class="fas fa-user-edit"></i>
                                <span class="responsive_title">Actions</span>
                            </th>
                            <th style="width: 5%" class="action">
                                <i class="fas fa-toggle-on"></i>
                                <span class="responsive_title">Statut</span>
                            </th>
                        </tr>
                        </thead>
                        <?php
                        foreach ($posts as $data): ?>
                            <tr>
                                <td>
                                    <?php $date->dateFR($data['creation_date_fr']);
                                    echo $date->dateFR;?>
                                </td>
                                <td class="postTitle">
                                    <?= '<a href="index.php?action=post&amp;id=' . $data['id'] . '">Chapitre ' . $data['chapnumber'] . ' ' . htmlspecialchars($data['title']) . '</a>'; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['comment_number'] > 0):?>
                                        <?= '<a href="admin.php?action=viewPostComments&amp;id=' . $data['id'] . '">' . htmlspecialchars($data['comment_number']) . '</a>'; ?>
                                    <?php
                                    else:?>
                                        <?= htmlspecialchars($data['comment_number']); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['online'] == 1): ?>
                                        <?= '<i class="fas fa-eye text-muted"></i> / <a href="admin.php?action=statusPost&amp;id=' . $data['id'] . '&amp;fromUrl=' . $Url . '"><i class="fas fa-eye-slash"></i></a>'; ?>
                                    <?php
                                    else:?>
                                        <?= '<a href="admin.php?action=statusPost&amp;id=' . $data['id'] . '&amp;fromUrl=' . $Url . '"><i class="fas fa-eye"></i></a> / <i class="fas fa-eye-slash text-muted"></i>'; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= '<a href="admin.php?action=editPost&amp;id=' . $data['id'] . '"><i class="fas fa-edit"></i></a>'; ?>
                                </td>
                                <td>
                                    <?= '<a href="admin.php?action=deletePost&amp;id=' . $data['id'] . '&amp;fromUrl=' . $Url . '" onclick="return confirm(\'Etes-vous sûr de vouloir supprimer le billet?\')"><i class="fas fa-trash"></i></a>'; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['online'] == 1): ?>
                                        <i class="fas fa-circle text-success"></i>
                                    <?php
                                    else:?>
                                        <i class="fas fa-circle text-danger"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <footer class="row col-sm-12">
    </footer>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>