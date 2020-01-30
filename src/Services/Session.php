<?php

namespace App\Services;

class Session
{
    public function __construct()
    {
        if (session_status() != 2) {
            session_start();
        }
    }

    public function stopSession()
    {
        session_destroy();
    }
}