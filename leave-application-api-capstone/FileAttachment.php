<?php
require_once ("DBQueries.php");
require_once ("Functions.php");

class FileAttachment {

    public $fileName;
    public $file;
    private $folderName = 'attachments/';

    public function __construct($fileName = '') {
        $this->fileName = $fileName;
        $this->openFile();
    }

    public function openFile() {
        $this->file = fopen($this->folderName . $this->fileName, "r") or  die("Unable to open file!");
    }

    public function getContent(){
        $content = "";
        while ($line = fgets($this->file)) {
            $content .= $line;
        }
        return $content;
    }

    public function setContent($newContent) {
        $file = fopen($this->folderName . $this->fileName, "w") or  die("Unable to open file!");
        fwrite($file, $newContent);
        fclose($file);
        $this->openFile();
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}