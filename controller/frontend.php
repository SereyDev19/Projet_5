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

function GlobalReport($accountsList)
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\App\Model\GetDBData();
        $DBaccounts = $getDBData->getAccounts();


        require('view/frontend/dashboard.php');
    } else {
        require('view/backend/login.php');
    }

}