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
                <h2 class="white">Commentaires par article</h2>
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
                        <?php if($notification['new_notifications']==1):;?>
                            <i class="fas fa-exclamation-circle"></i>
                        <?php endif;?>
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
        <section class="col-sm-12">
            <div class="panel panel-primary">
                <div class="row">
                    <div class="col-xl-6">
                        <p class="comments"><em>Commentaires</em></p>
                <?php
                foreach ($comments as $comment):
                ?>
                    <?php
                    if ($comment['visible'] == 1): ?>
                        <div class="listcomments visible">
                            <p class="hisname"><strong><?= htmlspecialchars($comment['author']) ?></strong></p>
                            <p class="hisdate"><?= $comment['comment_date_fr'] ?></p></br>
                            <p class="hiscomment"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                            <?php echo '<a href="admin.php?action=delComment&amp;id=' . $comment['id'] . '&amp;fromUrl='.$Url.'" onclick="return confirm(\'Etes-vous sûr de vouloir supprimer le commentaire?\')">Supprimer le commentaire</a>'?>
                            <?php echo '<a href="admin.php?action=maskComment&amp;id=' . $comment['id'] . '&amp;fromUrl='.$Url.'">Masquer le commentaire</a>'?>
                            <p class="reported">Signalé : <?= nl2br(htmlspecialchars($comment['reported'])) ?> fois</p>
                        </div>
                    <?php
                    else:?>
                        <div class="listcomments hidden">
                            <p class="hisname"><strong><?= htmlspecialchars($comment['author']) ?></strong></p>
                            <p class="hisdate"><?= $comment['comment_date_fr'] ?></p></br>
                            <p class="hiscomment"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                            <?php echo '<a href="admin.php?action=delComment&amp;id=' . $comment['id'] . '&amp;fromUrl='.$Url.'" onclick="return confirm(\'Etes-vous sûr de vouloir supprimer le commentaire?\')">Supprimer le commentaire</a>'?>
                            <?php echo '<a href="admin.php?action=maskComment&amp;id=' . $comment['id'] . '&amp;fromUrl='.$Url.'">Afficher le commentaire</a>'?>
                            <p class="reported">Signalé : <?= nl2br(htmlspecialchars($comment['reported'])) ?> fois</p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                    </div>
                    <div class="col-xl-6">
                        <div class="posts post-<?= $post['id']; ?>">
                            <div id="excerptpost">
                                <p class="chapterName">Chapître
                                    <?= $post['id']; ?>
                                </p>
                                <!--                </-->
                                <!--                >-->
                                <h2>
                                    <?= htmlspecialchars($post['title']); ?>
                                </h2>
                                <div class="date">
                                    <p class="date">
                                        <?php $date->dateFR($data['creation_date_fr']);
                                        echo $date->dateFR;?>
                                        - Billet simple pour l'Alaska</p>
                                </div>

                                <p>
                                    <?php echo substr(nl2br(htmlspecialchars($post['content'])), 0, 555);
                                    ?>[...]
                                    <br/>
                                <div id="more">
                                </p>

                                <p>
                                    <?php echo '<a href="index.php?action=post&amp;id=' . $post['id'] . '">Lire la suite'
                                    ?>
                                    <?= '<i class="fas fa-feather-alt"></i></a>'; ?>
                                </p>
                            </div>
                        </div>
                    </div>



                    </div>
                </div>
            </div>
        </section>
    </div>
    <footer class="row col-sm-12">
    </footer>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>