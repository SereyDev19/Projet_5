<?php ob_start();
require('view/helper.php');
$date = new date();
?>
    <div id="content" class="content-post">
        <div id="connection">
            <?php
            if (isset($_SESSION['user_id']) AND isset($_SESSION['username'])): ?>
                <a href="admin.php">(Connecté) Retour au tableau de bord</a>
                <a id="deconnexion" href="admin.php?action=logout">Déconnexion</a>
            <?php
            else:?>
                <a href="admin.php">Connexion (Administrateur)</a>
            <?php endif; ?>
        </div>
        <div id="header_image">
            <h1 id="blogTitle">Blog de Jean Forteroche</h1>
            <div id="GreenFilter"></div>
        </div>
        <div id="mainTitle">
            <h1 id="bookTitle">Billet simple pour l'Alaska</h1>
            <h2>Jean Forteroche</h2>
        </div>
        <div class="row col-sm-12">
            <div class="btn-group">
                <a href="index.php"><button type="button" class="btn btn-primary"><i class="fas fa-home"></i> Accueil</button></a>
                <div class="btn-group dropright">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <i class="far fa-list-alt"></i>
                        Articles
                    </button>
                    <div class="dropdown-menu">
                        <?php
                        foreach ($posts as $data):
                            if ($data['online'] == 1): ?>
                                <a class="dropdown-item" href="index.php?action=post&amp;id=<?= $data['id'];?>">Chapitre <?= $data['chapnumber'].' '.$data['title'];?></a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    <div class="posts post-<?= $post['chapnumber']; ?>">
        <div id="chapterfilter">
            <div id="chapter">
                <p class="chapterName">Chapitre
                    <?= $post['chapnumber']; ?>
                </p>

                <div id="chapterhead">
                        <h2>
                        <?= htmlspecialchars($post['title']); ?>
                        </h2>
                </div>
            <div class="date">
                <p class="date">
                    <?php $date->dateFR($data['creation_date_fr']);
                    echo $date->dateFR;?>
                    - Billet simple pour l'Alaska
                </p>
            </div>

            <p>
                <?php echo nl2br($post['content']);?>
            <p>
            </div>
        </div>
    </div>

    <div id="commentsblock">
    <p class="comment"><em>Ajouter un commentaire</em></p>

    <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
        <div class="authorinput">
            <label for="author">Auteur</label><br/>
            <input type="text" id="author" name="author"/>
        </div>
        <div class="commentinput">
            <label for="comment">Commentaire</label><br/>
            <textarea id="comment" name="comment"></textarea>
        </div>
        <div>
            <input type="submit"/>
        </div>
    </form>

    <?php
    foreach ($comments as $comment): ?>
        <?php
        if($comment['visible'] == 1):
            $isComment = true;?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php
    if(isset($isComment)): ?>
        <p class="comments"><em>Commentaires</em></p>
    <?php endif; ?>

    <?php
    foreach ($comments as $comment): ?>
        <?php
        if($comment['visible'] == 1): ?>

    <div class="listcomments">
        <p class="hisname"><strong><?= htmlspecialchars($comment['author']) ?></strong></p>
        <p class="hisdate"><?= $comment['comment_date_fr'] ?></p></br>
        <p class="hiscomment"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        <?php echo '<a href="index.php?action=reportComment&amp;postId='.$comment['post_id'].'&amp;id=' . $comment['id'] . '">Signaler le commentaire</a>'
        ?>
    </div>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
    <!--</body>-->
    <!--</html>-->
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>