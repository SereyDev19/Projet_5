<?php

namespace App\Services;


//require_once("model/backend/Session.php");

class UserSession extends Session
{
    protected $USER = '';
    protected $connect = false;
    protected $userName = '';
    public $userId = '';
    public $levelAccess = 0;

    /**
     * @param $username
     * @param $userid
     * @param $levelAccess
     */
    public function registerUser($username, $userid, $levelAccess)
    {
        $this->USER = $username;
        $_SESSION['user_id'] = $userid;
        $_SESSION['username'] = $username;
        $_SESSION['level_access'] = $levelAccess;
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (isset($_SESSION['username'])) {
            $this->USER = $_SESSION['username'];
            $this->userName = $_SESSION['username'];
            $this->userId = $_SESSION['user_id'];
            $this->levelAccess = $_SESSION['level_access'];
            $connect = true;
            return $connect;
        }
    }

    /**
     * @param $username
     */
    public function getUserInfo($username)
    {
        $this->userName = $_SESSION['username'];
        $this->userId = $_SESSION['username'];
    }

    /**
     * 
     */
    public function getCurrentSessionInfo()
    {
        var_dump($this->userId);
        var_dump($this->userName);
        var_dump($this->levelAccess);
    }
}