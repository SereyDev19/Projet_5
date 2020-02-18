<?php

namespace App\Services;


class DataValidation
{
    /**
     * @param $data
     * @return string
     * Escape the special characters
     */
    public function escapeSpecChars($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validationName($name)
    {
        $this->newName = false;
        $name = $this->escapeSpecChars($name);
        $pattern = "/^[A-Z]/";
        if (!empty($name) && strlen($name) <= 20 && preg_match($pattern, $name)) {
            $this->newName = $name;
        }
        return $this->newName;
    }

    public function validationEmail($email)
    {
        $this->newEmail = false;
        $email = $this->escapeSpecChars($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->newEmail = $email;
        };
        return $this->newEmail;
    }

    public function validationId($id)
    {
        $this->newId = false;
        $id = $this->escapeSpecChars($id);
        $options = array("min_range" => 1e6, "max_range" => 1e9 - 1);
        if (filter_var($id, FILTER_VALIDATE_INT, array("options" => $options))) {
            $this->newId = $id;
        }
        return $this->newId;
    }

    public function Validation($data, $type)
    {
        switch ($type) {
            case 'email':
                $res = $this->validationEmail($data);
                break;
            case 'name':
                $res = $this->validationName($data);
                break;
            case 'password':
                $res = $data;
                break;
            case 'id':
                $res = $this->validationId($data);
                break;
        }
        return $res;
    }

}
