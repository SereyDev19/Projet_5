<?php

namespace SC19DEV\App\Model;
require_once("model/Manager.php");

class UserManager extends Manager
{
    public $message = '';
    public $isCorrect = false;
    public $username = '';
    public $user_id = '';

    public function verifyUser($username, $password)
    {
        if ($username !== "" && $password !== "") {

            $db = $this->db;

            //  Test si l'utilisateur existe
            $req = $db->prepare('SELECT user_id, user_password FROM users WHERE user_name = ?');
            $req->execute(array($username));
            $resultat = $req->fetch();

            if ($resultat == null) {
                $this->message = 'Utilisateur non reconnu';
            } else {

                $isPasswordCorrect = password_verify($password, $resultat['user_password']);

                if ($isPasswordCorrect == false) {
                    $this->message = 'Mot de passe incorrect';
                } else {
                    $this->message = 'Bienvenue ' . $username;
                    $this->isCorrect = true;
                    $this->username = $username;
                    $this->user_id = $resultat['user_id'];
                }
            }
            return $this->isCorrect;
        }
    }
}
