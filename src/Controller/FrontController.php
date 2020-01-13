<?php

namespace App\Controller;

use App\Model\backend\Session;
use App\Model\backend\UserSession;
use App\Model\backend\UserManager;

class FrontController extends Controller
{
//    public function __construct()
//    {
//        var_dump('Instanciation FrontController');
//    }

    public function FrontGlobalReport($access_id)
    {
//        var_dump('access_id : ', $access_id);
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $allAccounts = $getDBData->getAccessAccountsId($access_id);
//            var_dump('tous les comptes : ', $allAccounts);
            $DBaccounts = $getDBData->getAccountsFromList($allAccounts);

            require('view/frontend/dashboard.php');
        } else {
            require('view/backend/loginEmail.php');
        }
    }

    public function home()
    {
        $list = array (
            array('aaa', 'bbb', 'ccc', 'dddd'),
            array('123', '456', '789'),
            array('"aaa"', '"bbb"')
        );

        $fp = fopen('file.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        // envoi d'un email à webmaster@tutovisuel.com
//        mail("serey.chhim@gmail.com", "Sujet", "Le message\nligne2");

//Generate a random string.
        $token = openssl_random_pseudo_bytes(56);

//Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        require('view/frontend/homeView.php');
    }

}