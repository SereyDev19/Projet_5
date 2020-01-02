<?php

//phpinfo();
//die();
require('controller/frontend.php');
try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            listPosts(true);
        } elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post(true);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');

            }
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] = 'reportComment') {
            reportComment($_GET['postId'], $_GET['id']);
        }
    } else {
        listPosts(true);
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
