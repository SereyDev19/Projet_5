<?php

namespace SC19DEV\App\Model;
require_once("model/Manager.php");

class NotificationManager extends Manager
{
    public function isNewNotification()
    {
        $sql = 'SELECT new_notifications FROM notifications';
        $newNotifications = $this->getOne($sql, []);

        return $newNotifications;
    }

    public function NewNotification()
    {
//        $sql = 'SELECT new_notifications FROM notifications';
//        $notification = $this->getColumn($sql, []);
//
//        if (boolval($notification) == true) {
//            $val = 0;
//        } else {
//            $val = 1;
//        }

        $sql = 'UPDATE notifications SET new_notifications = ?';
        $req = $this->executeStatement($sql, [1]);
    }

    public function turnOffNotification(){
        $sql = 'UPDATE notifications SET new_notifications = ?';
        $req = $this->executeStatement($sql, [0]);
    }
}