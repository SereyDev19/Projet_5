<?php

namespace App\Services;

class FlashBag extends Session
{
    protected $USER = '';
    protected $connect = false;
    protected $userName = '';
    protected $userId = '';
    public $cssId = 'alert alert-danger';

    /**
     * @param $message
     * @param string $type
     */
    public function add($message, $type = 'error')
    {
        $_SESSION['flash'] = array(
            'message' => $message,
            'type' => $type
        );
    }

    /**
     *
     */
    public function flash()
    {
        if (isset($_SESSION['flash'])) {
            if ($_SESSION['flash']['type'] == 'success')
                {
                    $this->cssId = 'alert alert-success';
                }
            ?>
            <div id=alert class=" <?= $this->cssId ;?>" role="alert">
                <?= $_SESSION['flash']['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
    }

    /**
     *
     */
    public function fetchMessages()
    {
        unset($_SESSION['flash']);
    }

}