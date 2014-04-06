<?php
namespace Sketch\Views;

class AdminView extends View
{
   public function __construct($controller) {
       parent::__construct($controller);

       // GET Template
       $template = \Sketch\Sketch::$instance->url;       
       $view = strtolower(end($template));
       $this->layout    = SKETCH_CORE.DIRECTORY_SEPARATOR."Sketch".
                        DIRECTORY_SEPARATOR."Admin".DIRECTORY_SEPARATOR
                        .$view.".html";
   }
}