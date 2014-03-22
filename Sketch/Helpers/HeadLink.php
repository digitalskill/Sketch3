<?php
namespace Sketch\Helpers;

class HeadLink{
    private $links = array();
    private $files = array();
    public function __construct(){
        return $this;
    }
    private function createLink($path,$media){
        if(!isset($this->files[$media])){
            $this->files[$media] = array();
        }
        $this->files[$media][] = $path;
        return array('<link href="'.$path.'" media="'.$media.'" rel="stylesheet" type="text/css">');
    }
    public function appendFile($path,$media="screen"){
        $this->links = array_merge($this->links,$this->createLink($path,$media));
        return $this;
    }
    public function prependFile($path,$media="screen"){
        $this->links = array_merge($this->createLink($path,$media),$this->links);
        return $this;
    }
    public function __toString() {
        return join("",$this->links);
    }
    public function minify(){
        $this->links = array();
        $base = \Sketch\Views\View::$instance->basePath();
        foreach($this->files as $media => $files){
            $this->links[] = '<link href="/minifycss/'.str_replace($base,"",join(":",$files)).'" media="'.$media.'" rel="stylesheet" type="text/css">';
        }
        return $this;
    }
}
