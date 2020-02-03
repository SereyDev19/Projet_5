<?php

namespace App\Model;

use App\Config\Config;
class UserManager extends Config
{
    public $message = '';
    public $isCorrect = false;
    public $errorPassword = false;
    public $isId = false;
    public $isEmail = false;
    public $alreadyDefined = false;
    public $username = '';
    public $user_id = '';
    public $access_level = '';

    /**
     * @param $accessId
     * @return bool
     */
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

    /**
     * @param $email
     * @return bool
     */
    public function verifyEmail($email)
    {
        $db = $this->db;

        //  Test si l'Id existe
        $sql = 'SELECT * FROM access WHERE access_email = ?';
        $resultat = $this->getOne($sql, [$email]);
        if ($resultat != null) {
            $this->isEmail = true;

            $this->message = 'Email déjà utilisé';
        }

        return $this->isEmail;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function verifyUser($email, $password)
    {
        if ($email !== "" && $password !== "") {

            $db = $this->db;

            //  Test si l'utilisateur existe
            $sql = 'SELECT access_level, access_id, access_firstname ,access_password FROM access WHERE access_email = ?';
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
                    $this->access_level = $resultat['access_level'];
                    $this->username = $resultat['access_firstname'];
                    $this->user_id = $resultat['access_id'];
                }
            }
            return $this->isCorrect;
        }
    }

    /**
     * @param $access_id
     * @return bool
     */
    public function passwordDefined($access_id)
    {
        $db = $this->db;

        //  Test si le password existe
        $sql = 'SELECT access_password FROM access WHERE access_id = ?';
        $resultat = $this->getOne($sql, [$access_id]);
        var_dump($resultat);


//        if ($resultat[0] != null) {
        if ($resultat['access_password'] != null) {
            $this->message = 'Un compte a déjà été créé pour l\'identifiant' . $access_id;

            $this->alreadyDefined = true;
        }
        return $this->alreadyDefined;
    }

    /**
     * @param $password
     * @param $confirmpassword
     * @return bool
     */
    public function errorDefiningPassword($password, $confirmpassword)
    {

        if ($password != $confirmpassword) {
            $this->message = 'Le mot de passe n\'a pas été correctement saisi';

            $this->errorPassword = true;
        }
        return $this->errorPassword;
    }
}
