<?php

namespace App\Services;


class DataValidation
{
    /**
     * @param $data
     * @return string
     * Escape the special characters
     */
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
