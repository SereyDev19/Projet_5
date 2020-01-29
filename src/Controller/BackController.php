<?php
/**
 * BackController class.
 *
 * @author Sérey Chhim
 */

namespace App\Controller;

use App\Model\Backend\Session;
use App\Model\Backend\UserSession;
use App\Model\Backend\UserManager;
use App\Model;

use Twig_Loader_Filesystem;
use Twig_Environment;

class BackController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function adminVerification()
    {
        $userManager = new UserManager();
        $userExists = $userManager->verifyUser($_POST['email'], $_POST['password']);

        $flashbag = new FlashBag();

        if (!$userManager->isCorrect) {
            $this->Login();
//            adminLogin();
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        $userSession = new UserSession();
        $userSession->registerUser($userManager->username, $userManager->user_id, $userManager->access_level);

        $flashbag->add($userManager->message, 'success');
        $flashbag->flash();
        $flashbag->fetchMessages();

        if ($userManager->access_level == 0) {
            $this->GlobalReport($userManager->user_id);
        }
        $this->adminGlobalReport();
    }

    public function adminGlobalReport()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData();
            $DBaccounts = $getDBData->getAccounts();

            echo $this->twig->render('dashboard.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'DBaccounts' => $DBaccounts]);
        } else {
            echo $this->twig->render('loginEmail.html.twig');

        }
    }

    public function adminManageAccess()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData();
            $AccessManager = new \App\Model\ManageAccess();

            $DBaccounts = $getDBData->getAccounts();
            $allAccess = $AccessManager->getAccess();

//            require('view/frontend/access.php');
            echo $this->twig->render('access.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'allAccess' => $allAccess, 'DBaccounts' => $DBaccounts]);

        } else {
            require('view/backend/login.php');
        }
    }

    public function adminAddAccess($account_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $DBaccounts = $getDBData->getAccounts();
            $AccessManager = new \App\Model\ManageAccess();
            $var = random_int(1e6, 1e9 - 1);
            while (!$AccessManager->IdAlreadyUsed($var)) {
                $var = random_int(1e6, 1e9 - 1);
                var_dump($AccessManager->IdAlreadyUsed($var));
            }
            $AccessManager->addAccess($account_id, $var);

            $this->adminManageAccess();

        } else {
            require('view/backend/login.php');
        }
    }

    public function adminDeleteAccess($access_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $AccessManager = new \App\Model\ManageAccess();
            $AccessManager->deleteAccess($access_id);
        }
    }
}