<?php ob_start(); ?>

<body>
<div id="dashboard" class="container">
    <header class="row col-sm-12">
        <div class="page-header">
            <h1>Tableau de bord</h1>
            <h2 class="white">Créer un nouvel article</h2>
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
                <div id="main">

                    <form id="formNewPost" action="admin.php?action=addPost" method="post">
                        <div class="index">
                            <label for="index">N° de chapitre</label><br/>
                            <input type="number" id="index" name="index"/>
                        </div>
                        <div class="title">
                            <label for="title">Titre</label><br/>
                            <input type="text" id="title" name="title"/>
                        </div>

                        <div class="content">
                            <label for="content">Article</label><br/>
                            <textarea id="content_post" name="content"></textarea>
                        </div>
                        <div id="submit">
                            <input value="Publier" name="action" type="submit"/>
                            <input value="Enregistrer" name="action" type="submit"/>
                        </div>
                    </form>
                </div>

        </section>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/w4adj4fs0gpibiunovjzdisd1v6m1ivvji3sw8klqhke24im/tinymce/5/tinymce.min.js"></script>
<script src="js/tinymce.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
