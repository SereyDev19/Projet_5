<?php

namespace SC19DEV\App\Router;

use phpDocumentor\Reflection\Types\Null_;

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
        switch ($action) {
            case 'reportAccount':
                adminReportAccount($params['account_id']);
                break;
            case 'signIn':
                adminSignIn();
                break;
            case 'logout':
                adminLogout();
                break;
            case 'detailedReport':
                admindetailedReport($params['account_id']);
                break;
            case 'updateData':
                APIdetailedReport($params['account_id']);
            case 'globalreport':
                adminGlobalReport();
                break;
            case 'updateAccountData':
                APIGlobalReport();
                break;
            case 'manageAccess':
                adminManageAccess();
                break;
            case 'addAccess':
                adminAddAccess($params['account_id']);
            case '':
                adminGlobalReport();
        }
    }

    public function post($action, array $params)
    {
        var_dump($action);
        switch ($action) {
            case 'signIn':
                var_dump('signin');
                adminRegisterNewAccess($params);
                break;
            case 'logIn':
                var_dump('login');
                adminVerification();
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
            var_dump('lancement requete post');
            $this->post($this->action, $this->params);
        }

    }
}