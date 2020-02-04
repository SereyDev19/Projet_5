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
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
