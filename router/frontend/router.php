<?php

namespace SC19DEV\App\Router\Frontend;

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
            case '':
                listPosts(true);
                break;

        }
    }

    public function post($action, array $params)
    {
        switch ($action) {
            case 'signIn':
                adminRegisterNewAccess($params);
                break;
            case 'logIn':
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
            $this->post($this->action, $this->params);
        }

    }
}