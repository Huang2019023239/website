<?php
class FileUpload{
    private $path = "./uploads";
    private $allowtype = array('jpg','gif','png');
    private $maxsize = 1000000;
    private $israndname = True;
    private $originname;
    private $tmpFileName;
    private $fileType;
    private $fileSize;
    private $newFileName;
    private $errorNum = 0;
    private $errorMess="";

function set($key, $val){
    $key = strtolower($key);
    if(array_key_exists($key,get_class_vars(get_class($this)))){
        $this->setOption($key,$val);
    }
    return $this;
}
function upload($fileField){
    $return = True;
    if(!$this->checkFilePath()){
        $this->errorMess = $this->getError ();
        return False;
    }
    $name = $_FILES[$fileField]['name'];
    $tmp_name = $_FILES[$fileField]['tmp_name'];
    $size = $_FILES[$fileField]['size'];
    $error = $_FILES[$fileField]['error'];
    if (is_array($name)){
        $errors = array();
        for ($i = 0;$i < count($name);$i++){
            if ($this->setFiles($name[$i],$tmp_name[$i],$size[$i],$error[$i])){
                if (!$this->checkFileSize() || ! $this->checkFileType ()){
                    $error [] =$this->getError ();
                    $return = False;
                }
            }else{
                $error [] = $this->getError ();
                $return = False;
            }
            if (! $return)
                $this->setFiles();
        }
        if ($return){
            $fileNames = array();
            for ($i = 0; $i < count($name);$i++){
                if($this->setFiles($name[$i],$tmp_name[$i], $error[$i])){
                    $this->setNewFileName();
                    if (! $this->copyFile()){
                        $error [] = $this->getError ();
                        $return = False;
                    }
                    $fileNames [] = $this->newFileName;
                }
            }
            $this->newFileName = $fileNames;
        }
        $this->errorMess = $errors;
        return $return;
    }else{
        if ($this->setFiles ($name, $tmp_name, $size, $error)){
            if ($this->checkFileSize() && $this->checkFileType()){
                $this->setNewFileName();
                if ($this->copyFile()){
                    return True;
                }else{
                    $return = False;
                }
            }else{
                $return = False;
            }
        }else {
            $return = False;
        }
        if (! $return)
            $this->errorMess = $this->getError();
        return $return;
    }
}
public function getFileName(){
    return $this->newFileName;
}
public function getErrorMsg(){
    return $this->errorMess;
}
private function getError(){}    //待补充
private function setFiles($name="", $tmp_name="", $size=0, $error=0){}
private function setOption($key, $val){}
private function setNewFileName(){}
private function checkFileType(){}
private function checkFileSize(){}
private function checkFilePath(){}
private function proRandName(){}
private function copyFile(){}
}