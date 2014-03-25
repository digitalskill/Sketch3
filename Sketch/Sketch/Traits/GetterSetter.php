<?php
namespace Sketch\Traits;

trait GetterSetter
{
    public function __get($item)
    {
        return $this->$item;
    }
    public function __set($item,$value)
    {
        $this->$item = $value;
    }
}
