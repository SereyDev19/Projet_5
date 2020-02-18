<?php

namespace App\Services;


class UploadFile
{
    public $message = '';
    public $msgtype = 'error';

    /**
     * UploadFile constructor.
     * @param $userId
     */
    public function __construct($userId)
    {

        $this->userId = $userId;
        $this->workingDir = "uploads/" . $this->userId . "/";

        // Create an user directory if it does not exist
        if (!in_array($this->userId, scandir("uploads/"))) {
            mkdir($this->workingDir);
        };

        $this->cleanDir($this->workingDir);

        $this->contentDir = scandir("uploads/" . $userId);
        unset($this->contentDir[0]); // remove '.'
        unset($this->contentDir[1]); // remove '..'

        // Make the former profile picture a tmp file
        if ($this->contentDir != []) {
            $this->oldFile = $this->contentDir[2];
            $this->tmpFile = 'tmp_' . $this->userId . $this->contentDir[2];
            rename($this->workingDir . $this->oldFile, $this->workingDir . $this->tmpFile);
        }
    }

    /**
     * @param $dir
     */
    public function cleanDir($dir)
    {
        foreach (scandir($dir) as $file) {
            if (!($file == "." or $file == "..")) {
                if (stristr(basename($file), 'tmp_')) // Remove all tmp files
                    unlink($dir . $file);
            };
        };
    }

    /**
     * @param $oldFile
     * @return false|string
     */
    public function fileRename($oldFile)
    {
        $newfile = substr($oldFile, 0, 4);
        return $newfile;
    }

    /**
     *
     */
    public function upload()
    {
        // Deleting potential former pictures in the user directory
        foreach (scandir("uploads/" . $this->userId) as $file) {
            if (!($file == "." or $file == "..")) {
                if (!stristr(basename($file), 'tmp_')) // Remove all files except the temp file
                    unlink("uploads/" . $this->userId . "/" . $file);
            }
        };


        $target_dir = "uploads/" . $this->userId . "/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $this->message = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
                $this->msgtype = 'success';
            } else {
                $this->message = "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            $this->message = "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $this->message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $this->message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $this->msgtype = 'error';
            $this->message = $this->message . " Your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $this->message = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                $this->message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}