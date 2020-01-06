<?php

namespace SC19DEV\App\Model;
require_once("model/Manager.php");

class UserManager extends Manager
{
    public $message = '';
    public $isCorrect = false;
    public $isId = false;
    public $username = '';
    public $user_id = '';

    public function verifyAccessId($accessId)
    {
        if ($accessId !== "") {

            $db = $this->db;

            //  Test si l'Id existe
            $sql = 'SELECT access_firstname FROM access WHERE access_id = ?';
            $resultat = $this->getOne($sql, [$accessId]);

            if ($resultat == null) {
                $this->message = 'Identifiant non reconnu';
            } else {
                $this->username = $resultat['access_firstname'];
                $this->user_id = $accessId;
                $this->message = 'Bienvenue ' . $resultat['access_firstname'];
                $this->isId = true;
            }
            return $this->isId;
        }
    }

    public function verifyUser($email, $password)
    {
        if ($email !== "" && $password !== "") {

            $db = $this->db;

            //  Test si l'utilisateur existe
            $sql = 'SELECT access_id, access_firstname ,access_password FROM access WHERE access_email = ?';
            $resultat = $this->getOne($sql, [$email]);

            if ($resultat == null) {
                $this->message = 'E-mail non reconnu';
            } else {

//                $str = password_hash('admin',PASSWORD_BCRYPT);

                $isPasswordCorrect = password_verify($password, $resultat['access_password']);

                if ($isPasswordCorrect == false) {
                    $this->message = 'Mot de passe incorrect';
                } else {
                    $this->message = 'Bienvenue ' . $resultat['access_firstname'] . '!';
                    $this->isCorrect = true;
                    $this->username = $resultat['access_firstname'];
                    $this->user_id = $resultat['access_id'];
                }
            }
            return $this->isCorrect;
        }
    }
}
