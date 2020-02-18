<?php

namespace App\Services;


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
}