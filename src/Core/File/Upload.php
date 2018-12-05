<?php
namespace Ben09\Core\File;

use Psr\Http\Message\UploadedFileInterface;


class Upload
{
    /**
     * Path to save upload ex: public/uploads
     */
    protected $path;

    /**
    * 
    */
    protected $formats;

    public function __construct(string $path = null) {
        if(!is_null($path)) {
            $this->path = ROOT . DIRECTORY_SEPARATOR . $path;
        } else {
            $this->path = ROOT . DIRECTORY_SEPARATOR. 'uploads' . DIRECTORY_SEPARATOR . 'images';
        }

      
    }

    public function upload(UploadedFileInterface $file) {
       
        $fileName = $file->getClientFilename();
        $targetPath = $this->AddSufficIfExist($this->path . DIRECTORY_SEPARATOR . $fileName);
        $dirname = pathinfo($targetPath);
       
        //check if path exist 
        if(!file_exists($dirname['dirname'])) {
            mkdir($dirname['dirname'], 777,true);
        }

        $move = $file->moveTo($targetPath );
        
    }

    private function AddSufficIfExist($target) {
        if(file_exists($target)) {
            $infos = pathinfo($target);
            $target = $infos["dirname"] . DIRECTORY_SEPARATOR . $infos["filename"] .  '_copy.' . $infos['extension'];

            //recurssion(appel en boucle) avoid file overwriting 

            return $this->AddSufficIfExist($target);
        }

        return $target;
    }

    public function deleteFile($file) {
        if($file) {
            $file = $this->path . DIRECTORY_SEPARATOR . $file;
            if(file_exists($file)) {
                echo ($file);
                unlink($file);    
            }
        }   
    }

}