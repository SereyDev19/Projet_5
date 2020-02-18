<?php

namespace App\Router\Frontend;

use phpDocumentor\Reflection\Types\Null_;
use App\Controller\Controller;
use App\Controller\FrontController;

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
        $this->FrontController = new FrontController();

        switch ($action) {
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
            case 'globalreport':
                $this->Controller->GlobalReport();
                break;
            case 'glossary':
                $this->Controller->letterPagination();
                break;
            case '':
                $this->FrontController->home();
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