<?php
namespace Sketch\Views;

class AssetView extends View
{
    public function render($file = "")
    {
        if (is_file($this->layout)) {
            readfile($this->layout);
        } else {
            \Sketch\Sketch::$instance->status       = 404;
            \Sketch\Sketch::$instance->errors[]     = "File not found: ".$this->layout;
            $this->controller->doHeaders();
        }
    }
}
