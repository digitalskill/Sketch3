<?php
namespace Sketch\Views;

class View{
    public static $instance;
    public $controller;
    public function __construct($controller){
        self::$instance      = $this;
        $this->controller    = $controller;
        
        // Setup default layout and View for the page
        $this->layout        = SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR."layouts".FOLDER_SEPERATOR."index.php";
        $this->view          = SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR."content".FOLDER_SEPERATOR."index.php";
    }
   
    public function compress_page($buffer){
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n\n","\r","\t"),'',$buffer)));
    }
    
    public function render($file = ""){
        ob_start(array(__CLASS__,"compress_page"));
        if($file==""){
            $file = $this->layout;
            if(\Sketch\Sketch::$instance->status != 200){
                $file = SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR."errors".FOLDER_SEPERATOR."error".\Sketch\Sketch::$instance->status.".php";
            }
        }       
        if(is_file($file)){
            include($file);
        }else{
            \Sketch\Sketch::$instance->status       = 404;
            \Sketch\Sketch::$instance->errors[]     = "File not found: ".$file;
            $this->controller->doHeaders();
            if($file != SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR."errors".FOLDER_SEPERATOR."error404.php"){
                $this->render(SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR."errors".FOLDER_SEPERATOR."error404.php");
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
            $this->render(SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR.$file);
       }    
    }
   
    public function partial($file,$data=array()){
        if(count($data)==0){
            $this->render(SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR.$file);
        }else{
            $view = new \Sketch\Views\partialView($data);
            $view->render(SITE_ROOT.FOLDER_SEPERATOR.\Sketch\Sketch::$instance->getConfig("themePath").FOLDER_SEPERATOR.$file);
        }
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
    
    public function __get($item){
        return \Sketch\Sketch::$instance->getPageValues($item);
    }
    
    public function getMenuValues($item){
       return \Sketch\Sketch::$instance->getMenuValues($item); 
    }
    
    public function getSiteValues($item){
         return \Sketch\Sketch::$instance->getSiteValues($item); 
    }
    
    public function getMenu($depth = 2){
        $em     = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        return $em->getRepository("Sketch\Entities\Menu")->getTopLevelMenuItems(\Sketch\Sketch::$instance->node['site']['id'],$depth);        
    }
}