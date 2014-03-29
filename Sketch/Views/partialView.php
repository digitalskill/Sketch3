<?php
namespace Sketch\Views;

class partialView extends View
{
    public $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function render($file='')
    {
        if (is_file($file)) {
            include($file);
        }
    }
    public function __get($item)
    {
        return isset($this->data[$item])? $this->data[$item] : false;
    }
}
