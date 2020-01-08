<?php

namespace App\Router;

//require('controller/Controller.php');
//require('controller/FrontController.php');
//require('controller/BackController.php');


use phpDocumentor\Reflection\Types\Null_;
use App\Controller\BackController;
use App\Controller\Controller;
use App\Controller\FrontController;

class Router
{
    public $request = '';
    public $get = [];
    public $post = [];
    public $action = '';
    public $params = [];

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];


    }

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
                break;
            case '':
                $this->Controller->GlobalReport();
                break;
        }
    }

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
                break;
        }
    }

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
            } else {
                $this->action = 'logIn';
            }
            $this->params = $this->post;
            unset($this->params[$this->action]);
        }

    }

    public function run()
    {
        if ($this->request == 'GET') {
            $this->get($this->action, $this->params);
        } else {
            $this->post($this->action, $this->params);
        }

    }
}