<?php
namespace Sketch\Traits;

trait GetterSetter { 
    function __get($item){
        return $this->$item;
    }
    function __set($item,$value){
        $this->$item = $value;
    }
}