<?php
namespace Sketch\Views;

class View{
    public static $instance;
    public $controller;
    public function __construct($controller){
        SELF::$instance      = $this;
        $this->controller    = $controller;
        $this->layout        = SITE_ROOT."/views/layouts/index.php";
        $this->view          = SITE_ROOT."/views/content/index.php";
    }
   
    public function compress_page($buffer){
        return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$buffer));
    }
    
    public function render($file = ""){
        ob_start(array(__CLASS__,"compress_page"));
        if($file==""){
            $file = $this->layout;
            if(\Sketch\Sketch::$instance->status != 200){
                $file = SITE_ROOT."/views/errors/error".\Sketch\Sketch::$instance->status.".php";
            }
        }       
        if(is_file($file)){
            include($file);
        }else{
            \Sketch\Sketch::$instance->status       = 404;
            \Sketch\Sketch::$instance->errors[]     = "File not found: ".$file;
            $this->controller->doHeaders();
            if($file != SITE_ROOT."/views/errors/error404.php"){
                $this->render(SITE_ROOT."/views/errors/error404.php");
            }else{
                echo $this->errorMessages();
            }
        }
        ob_end_flush();
    }
   
    public function content($file=""){
        if($file==""){
            $this->render($this->view);
        }else{
            $this->render(SITE_ROOT."/views/".$file);
       }    
    }
   
    public function partial($file){
        $this->render(SITE_ROOT."/views/".$file);
    }
   
    public function headLink(){
        return new \Sketch\Helpers\HeadLink();
    }
    
    public function headScript(){
        return new \Sketch\Helpers\HeadScript();
    }
    
    public function basePath($file = ''){
        return \Sketch\Sketch::$instance->basePath($file);
    }
    
    public function inlineScript(){
        return new \Sketch\Helpers\HeadScript();
    }
    public function errorMessages(){
        return join("<br />",\sketch\Sketch::$instance->errors);
    }  
    
    public function doctype(){
        return "<!DOCTYPE html>";
    }
    
    public function __get($name){
        return \Sketch\Sketch::$instance->getPageValues($name);
    }
}