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
        $this->file = fopen($this->folderName . $this->fileName, "r") or '';
        //echo fread($myfile,filesize("webdictionary.txt"));
    }

    public function getContent(){
        $content = "";
        while ($line = fgets($this->file)) {
            $content .= $line;
            break;
        }
        return $content;
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}


$file = new FileAttachment('2018-06-10 20-11-53 f1e89e0496068ad6d202d63e11cccd4a');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Display Image</title>
</head>
<body>
<img
     src="<?php echo $file->getContent(); ?>" />
</body>
</html>
