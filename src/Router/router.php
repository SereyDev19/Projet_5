<?php

namespace App\Router;

//require('controller/Controller.php');
//require('controller/FrontController.php');
//require('controller/BackController.php');


use App\Services\UploadFile;
use phpDocumentor\Reflection\Types\Null_;
use App\Controller\BackController;
use App\Controller\Controller;
use App\Controller\FrontController;
use App\Services\DataValidation;

class Router
{
    public $request = '';
    public $get = [];
    public $post = [];
    public $action = '';
    public $params = [];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $action
     * @param array $params
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function get($action, array $params)
    {
        $this->Controller = new Controller();
        $this->BackController = new BackController();
        $this->FrontController = new FrontController();

        switch ($action) {
            case 'reportAccount':
                $this->Controller->ReportAccount($params['account_id']);
                break;
            case 'signIn':
                $this->Controller->SignIn();
                break;
            case 'logout':
                $this->Controller->Logout();
                break;
            case 'profile':
                $this->Controller->GetProfile();
                break;
            case 'detailedReport':
                $this->FrontController->DetailedReport($params['account_id']);
                break;
            case 'updateData':
                $this->Controller->APIdetailedReport($params['account_id']);
                $this->FrontController->DetailedReport($params['account_id']);
                break;
            case 'globalreport':
                $this->Controller->GlobalReport();
                break;
            case 'updateAccountDataByMonth':
                $this->Controller->APIGlobalReportDates($params['account_id'], $params['start'], $params['end']);
                $this->Controller->ReportAccount($params['account_id']);
                break;
            case 'updateAccountDataByDay':
                $this->Controller->APIGlobalReportDatesDay($params['account_id'], $params['start'], $params['end']);
                $this->Controller->ReportAccount($params['account_id']);
                break;
            case 'updateAccountData':
                $this->Controller->APIGlobalReport();
                $this->Controller->ReportAccount($params['account_id']);
                break;
            case 'manageAccess':
                $this->Controller->ManageAccess();
                break;
            case 'addAccess':
                $this->BackController->adminAddAccess($params['account_id']);
                break;
            case 'deleteAccess':
                $this->BackController->adminDeleteAccess($params['access_id']);
                $this->Controller->ManageAccess();
                break;
            case 'click2validate':
                $this->Controller->click2validate($params['token']);
                break;
            case 'ConnectWithEmail';
                $this->Controller->Login([$params['email']]);
                break;
            case 'exportAccountData':
                $this->Controller->newExportData($params['account_id']);
                $this->Controller->ReportAccount($params['account_id']);
                break;
            case 'exportAccountDetailedData':
                $this->Controller->newExportDetailedData($params['account_id']);
                break;
            case 'testAJAX':
                $this->Controller->testAJAX($params['account_id']);
                break;
            case 'glossary':
                $this->Controller->letterPagination();
                break;
            case '':
                $this->Controller->GlobalReport();
                break;
        }
    }

    /**
     * @param $action
     * @param array $params
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function post($action, array $params)
    {
        $this->Controller = new Controller();
        $this->BackController = new BackController();
        $this->FrontController = new FrontController();

        switch ($action) {
            case 'signIn':
                $this->Controller->RegisterNewAccess($params);
                break;
            case 'logIn':
                $this->Controller->Verification();
                $this->Controller->GlobalReport();
                break;
            case 'upload':
                $this->Controller->GetProfile();
                break;
            case 'searchWord':
                $this->Controller->searchWord($params['word']);
                break;
        }
    }

    /**
     *
     */
    public function method()
    {
        if ($this->request == 'GET') {
            $this->get = $_GET;
            if ($this->get != null) {
                $this->action = $this->get['action'];
                $this->params = $this->get;
                unset($this->params['action']);
            }

        } else {
            $this->post = $_POST;
            if (in_array('Inscription', $this->post)) {
                $this->action = 'signIn';
            } elseif (in_array('UploadImage', $this->post)) {
                $this->action = 'upload';
            } elseif (in_array('Chercher', $this->post)) {
                $this->action = 'searchWord';
            } else {
                $this->action = 'logIn';
            }
            $this->params = $this->post;
            unset($this->params[$this->action]);
        }

    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function run()
    {
        if ($this->request == 'GET') {
            $this->get($this->action, $this->params);
        } else {
            $this->post($this->action, $this->params);
        }

    }
}