<?php ob_start(); ?>
<?php $Url = urlencode("http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);
require('view/helper.php');
$date = new date();
?>

<body>
    <div id="dashboard" class="container">
        <header class="row col-sm-12">
            <div class="page-header">
                <h1>Tableau de bord</h1>
                <h2 class="white">Commentaires signalés</h2>
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
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-list-alt"></i>
                    Trier par :
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin.php?action=sortComments&amp;reported=false&amp;sort=date&amp;order=ASC">
                        Date <i class="fas fa-sort-up"></i>
                    </a>
                    <a class="dropdown-item" href="admin.php?action=sortComments&amp;reported=false&amp;sort=date&amp;order=DESC">
                        Date <i class="fas fa-sort-down"></i>
                    </a>
                    <a class="dropdown-item" href="admin.php?action=sortComments&amp;reported=false&amp;sort=post&amp;order=ASC">
                        Article <i class="fas fa-sort-up"></i>
                    </a>
                    <a class="dropdown-item" href="admin.php?action=sortComments&amp;reported=false&amp;sort=post&amp;order=DESC">
                        Article <i class="fas fa-sort-down"></i>
                    </a>
                </div>
            </div>
        </div>
        <section class="col-xl-12">
            <div class="panel panel-primary">
                <table class="table table-striped table-condensed table-hover border-0">
                    <thead>
                    <tr>
                        <th style="width: 10%" class="responsive_post">
                            <i class="far fa-calendar-alt"></i>
                            <span class="responsive_title">Date</span>
                        </th>
                        <th style="width: 20%">
                            <i class="fas fa-feather-alt"></i>
                            <span class="responsive_title">Auteur</span>
                        </th>
                        <th style="width: 30%">
                            <i class="far fa-comment-alt"></i>
                            <span class="responsive_title">Commentaire</span>
                        </th>
                        <th style="width: 10%">
                            <i class="far fa-thumbs-down"></i>
                            <span class="responsive_title">Signalé</span>
                        </th>
                        <th style="width: 10%">
                            <i class="far fa-newspaper"></i>
                            <span class="responsive_title">Article</span>
                        </th>
                        <th style="width: 10%" colspan="2">
                            <i class="fas fa-user-edit"></i>
                            <span class="responsive_title">Actions</span>
                        </th>
                        <th style="width: 10%">
                            <i class="fas fa-toggle-on"></i>
                            <span class="responsive_title">Statut</span>
                        </th>
                    </tr>
                    </thead>
                    <?php
                    foreach($comments as $data): ?>
                        <?php
                        if($data['visible'] == 1): ?>
                            <tr>
                        <?php
                        else:?>
                            <tr>
                        <?php endif; ?>

                        <td style="width: 10%" class="responsive_post">
                            <?php $date->dateFR($data['comment_date']);
                            echo $date->dateFR; ?>
                        </td>
                        <td style="width: 20%">
                            <?= htmlspecialchars($data['author']); ?>
                        </td>
                        <td style="width: 30%">
                                <?= '<a href="admin.php?action=viewPostComments&amp;id=' . $data['post_id'] . '">' . substr(nl2br(htmlspecialchars($data['comment'])),0,20) . '[...]</a>'; ?>
                        </td>
                        <td style="width: 10%">
                            <?= $data['reported']; ?>
                        </td>
                        <td style="width: 10%">
                            <?= '<a href="index.php?action=post&amp;id=' .$data['post_id']. '">' .htmlspecialchars($titlePostList[$data['post_id']]). '</a>'; ?>
                        </td>
                        <td style="width: 10%">
                            <?php
                            if($data['visible'] == 1): ?>
                                <?= '<i class="fas fa-eye text-muted"></i>/<a href="admin.php?action=maskComment&amp;id=' .$data['id']. '&amp;fromUrl='.$Url.'"><i class="fas fa-eye-slash"></i></a>' ;?>
                            <?php
                            else:?>
                                <?= '<a href="admin.php?action=maskComment&amp;id=' .$data['id']. '&amp;fromUrl='.$Url.'" class="confirm">
                                    <i class="fas fa-eye"></i></a>/<i class="fas fa-eye-slash text-muted"></i>' ;?>
                            <?php endif; ?>
                        </td>
                        <td style="width: 10%">
                            <?= '<a href="admin.php?action=delComment&amp;id=' .$data['id']. '&amp;fromUrl='.$Url.'" onclick="return confirm(\'Etes-vous sûr de vouloir supprimer le commentaire?\')"><i class="fas fa-trash"></i></a>' ;?>
                        </td>
                        <td style="width: 10%">
                            <?php
                            if($data['visible'] == 1): ?>
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
        </section>

    </div>
    <footer class="row col-sm-12">
    </footer>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?><?php
