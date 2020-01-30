<?php
/**
 * FrontController class.
 *
 * @author Sérey Chhim
 */

namespace App\Controller;

use App\Services\Session;
use App\Services\UserSession;
use App\Services\UserManager;

use Twig_Loader_Filesystem;
use Twig_Environment;


class FrontController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function FrontGlobalReport($access_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData();
            $allAccounts = $getDBData->getAccessAccountsId($access_id);
            $DBaccounts = $getDBData->getAccountsFromList($allAccounts);

            echo $this->twig->render('dashboard.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'DBaccounts' => $DBaccounts]);

        } else {
            echo $this->twig->render('loginEmail.html.twig');
        }
    }

    public function home()
    {
        if (isset($_SESSION['user_id']) AND isset($_SESSION['username'])) {
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['username'];
        } else {
            $user_id = '';
            $user_name = '';
        }


        echo $this->twig->render('homeView.html.twig', ['user_id' => $user_id, 'user_name' => $user_name]);
    }
}