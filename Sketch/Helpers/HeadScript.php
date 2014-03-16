<?php
namespace Sketch\Helpers;

class HeadScript{
    private $links = [];
    public function __construct(){
        return $this;
    }
    private function createLink($path,$media){
        return array('<script src="'.$path.'"></script>');
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
}