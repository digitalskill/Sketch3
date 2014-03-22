<?php
namespace Sketch\Controllers;

class MinifyjsController extends MinifycssController{
    public $type    = "application/javascript";
    public $js    = "";
    public function indexAction(){
        $this->view         = $this;
        $this->cachePath    = SKETCH_CORE."/cache/".md5(join("/",\Sketch\Sketch::$instance->url)).".js";
        $this->createCache();
        return $this->view;
    }

    public function createCache(){
        if(!is_file($this->cachePath) || \Sketch\Sketch::$instance->getConfig('cache')!= true){
            $files = explode(":",str_replace("minifyjs/","",join("/",\Sketch\Sketch::$instance->url)));
            foreach($files as $file){
                if(is_file(SKETCH_CORE."/".$file)){
                    $this->js .= ";". \Sketch\Helpers\JSMin::minify(file_get_contents(SKETCH_CORE."/".$file));
                }elseif(is_file(SITE_ROOT."/".$file)){
                    $this->js .=";". \Sketch\Helpers\JSMin::minify(file_get_contents(SITE_ROOT."/".$file));
                }
            }
            file_put_contents($this->cachePath,$this->js);
        }
    }
}