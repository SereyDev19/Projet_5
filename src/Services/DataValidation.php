<?php

namespace App\Services;


class DataValidation
{

    public function Validation($data)
    {
//        header('Content-Type: text/plain');

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
//        echo $data;
        return $data;
    }
}
