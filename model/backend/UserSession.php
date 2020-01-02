<?php

namespace SC19DEV\Blog\Model;
require_once("model/backend/Session.php");

class UserSession extends Session
{
    protected $USER = '';
    protected $connect = false;
    protected $userName = '';
    protected $userId ='';


    public function registerUser($username, $userid)
    {
        $this->USER = $username;
        $_SESSION['user_id'] = $userid;
        $_SESSION['username'] = $username;
    }

    public function isLogged()
    {
        if (isset($_SESSION['username'])) {
            $connect = true;
            return $connect;
        }
    }

    public function getUserInfo($username)
    {
        $this->userName = $_SESSION['username'];
        $this->userId = $_SESSION['username'];
    }
}