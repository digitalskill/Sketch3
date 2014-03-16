<?php
namespace Sketch\Views;

class View{
    public static $instance;
    private $controller;
    public function __construct($controller){
        SELF::$instance      = $this;
        $this->controller    = $controller;
        $this->layout        = SITE_ROOT."/views/layouts/index.php";
        $this->view          = SITE_ROOT."/views/content/index.php";
    }
   
    public function render($file = ""){
        if($file==""){
            $file = $this->layout;
            if(\Sketch\Sketch::$instance->status != 200){
                $file = SITE_ROOT."/views/errors/error".\Sketch\Sketch::$instance->status.".php";
            }
        }       
        if(is_file($file)){
            include($file);
        }else{
            if($file != SITE_ROOT."/views/errors/error404.php"){
                \Sketch\Sketch::$instance->status       = 404;
                \Sketch\Sketch::$instance->errors[]     = "File not found: ".$file;
                $this->render(SITE_ROOT."/views/errors/error404.php");
            }else{
                $this->controller->doHeaders();
                echo $this->errorMessages();
            }
        }
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
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'/'.$file;
        return $protocol.$domainName;
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
        return \Sketch\Sketch::$instance->node->page->$name;
    }
}