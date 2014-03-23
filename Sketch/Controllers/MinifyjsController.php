<?php
namespace Sketch\Controllers;

class MinifyjsController extends MinifycssController{
    public $type    = "application/javascript";
    public $js    = "";
    public function indexAction(){
        $this->view         = $this;
        $this->cachePath    = SKETCH_CORE.FOLDER_SEPERATOR."cache".FOLDER_SEPERATOR.md5(join("/",\Sketch\Sketch::$instance->url)).".js";
        $this->createCache();
        return $this->view;
    }

    public function render(){
        if(\Sketch\Sketch::$instance->getConfig('cache')== true && is_file($this->cachePath)){
            readfile($this->cachePath);
        }else{
            echo $this->js;
        }
    }
    
    public function createCache(){
        if(!is_file($this->cachePath) || \Sketch\Sketch::$instance->getConfig('cache')!= true){
            $files = explode(":",str_replace("minifyjs/","",join("/",\Sketch\Sketch::$instance->url)));
            foreach($files as $file){
                $checkjs = explode(".",$file);
                if(is_file(SKETCH_CORE.FOLDER_SEPERATOR."Assets".FOLDER_SEPERATOR.$file) && end($checkjs)=="js"){
                    $this->js .= ";". \Sketch\Helpers\JSMin::minify(file_get_contents(SKETCH_CORE.FOLDER_SEPERATOR."Assets".FOLDER_SEPERATOR.$file));
                }elseif(is_file(SITE_ROOT.FOLDER_SEPERATOR.$file) && end($checkjs)=="js"){
                    $this->js .=";". \Sketch\Helpers\JSMin::minify(file_get_contents(SITE_ROOT.FOLDER_SEPERATOR.$file));
                }
            }
            if(\Sketch\Sketch::$instance->getConfig('cache')== true){
                file_put_contents($this->cachePath,$this->js);
            }
        }
    }
}