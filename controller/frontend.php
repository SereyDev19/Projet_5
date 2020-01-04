<?php
session_start();

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once ('model/NotificationManager.php');


function listPosts($online)
{
    require('view/frontend/homeView.php');
}

function post($online)
{

    $postManager = new SC19DEV\App\Model\PostManager();
    $commentManager = new SC19DEV\App\Model\CommentManager();
//    $posts = $postManager->getPosts($online,'postid','ASC');
    $posts = $postManager->getPosts(false,'postid','ASC');

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);
    $nbr = $postManager->getnbrPosts();


    $idListPost = array();

    foreach ($posts as $value) {
        $postId = $postManager->getPost($value['id']);
        array_push($idListPost, $postId);
    }

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new SC19DEV\App\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function reportComment($postId, $id)
{
    $commentManager = new SC19DEV\App\Model\CommentManager();
    $report = $commentManager->reportComment($id);

    $notificationManager = new \SC19DEV\App\Model\NotificationManager();
    $notificationManager->NewNotification();
    $notificationManager->isNewNotification();
//    var_dump($notificationManager->isNewNotification());

    header('Location: index.php?action=post&id=' . $postId);
}
