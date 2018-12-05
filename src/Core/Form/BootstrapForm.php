<?php
namespace Ben09\Core\Form;

class BootstrapForm
{

    public function __construct($method) {

        if(is_null($method) || $method === '') {
            $this->method = 'POST';
        } 
        else {
             $this->method = $method;
        }
        
       
    }

    public function start($file = false) {
        if($file) {
            $file = "enctype=\"multipart/form-data\"";
        } else {
            $file = '';
        }
         echo('<form action="" method="' . $this->method . '"' . $file .'>');
    }
    public function input($type,$name,$placeholder,$label,$id) {
            echo '<div class="form-group col-md-6">
            <label for="'. $id . '">' . $label . '</label>
            <input type="' . $type . '" class="form-control" id="' . $label .'" name ="' . $name . '" placeholder="'. $placeholder . '">
            </div>';
    }

    public function checkBox($name,$placeholder,$label,$id) {
        echo '<div class="form-group form-check col-md-6">
        <input type="checkbox" class="form-check-input" id="'. $id .'" name="' . $name .'">
        <label class="form-check-label" for="'. $id .'">' . $label .'</label>
        </div>';
    }


    public function submit($class = null) {
        if($class) {
            $class = 'class=" ' . $class .'"';
        }
        else {
            $class = 'class="btn btn-primary"';
        }
        echo '<div class="form-group col-md-6"><button type="submit"' . $class .'>Submit</button></div>';
    }

    public function end() {
        echo "</form>";
    }




}