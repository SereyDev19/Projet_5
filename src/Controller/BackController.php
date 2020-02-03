<?php
/**
 * BackController class.
 *
 * @author Sérey Chhim
 */

namespace App\Controller;

use App\Services\Session;
use App\Services\UserSession;
use App\Services\UserManager;
use App\Model;

use Twig_Loader_Filesystem;
use Twig_Environment;

class BackController extends Controller
{
    /**
     * BackController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Validates the login credentials
     */
    public function adminVerification()
    {
        $userManager = new UserManager($_ENV);
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

    /**
     * Global report for the permitted account(s)
     */
    public function adminGlobalReport()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData($_ENV);
            $DBaccounts = $getDBData->getAccounts();

            echo $this->twig->render('dashboard.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'DBaccounts' => $DBaccounts]);
        } else {
            echo $this->twig->render('loginEmail.html.twig');

        }
    }

    /**
     * Manage the differents access for the admin manager
     */
    public function adminManageAccess()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData($_ENV);
            $AccessManager = new \App\Model\ManageAccess($_ENV);

            $DBaccounts = $getDBData->getAccounts();
            $allAccess = $AccessManager->getAccess();

//            require('view/frontend/access.php');
            echo $this->twig->render('access.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'allAccess' => $allAccess, 'DBaccounts' => $DBaccounts]);

        } else {
            require('view/backend/login.php');
        }
    }

    /**
     * @param $account_id
     * Add a new access (admin action)
     * @throws \Exception
     */
    public function adminAddAccess($account_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData($_ENV);
            $DBaccounts = $getDBData->getAccounts();
            $AccessManager = new \App\Model\ManageAccess($_ENV);
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

    /**
     * @param $access_id
     * Remove an access (admin action)
     */
    public function adminDeleteAccess($access_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData($_ENV);
            $AccessManager = new \App\Model\ManageAccess($_ENV);
            $AccessManager->deleteAccess($access_id);
        }
    }
}