<?php
namespace Sketch\Controllers;

/**
 * Load up a HTML layout, view, and Model page
 */
class AdminController extends Controller
{
    public $type = "text/html";
    
    public function indexAction() {
        return new \Sketch\Views\AdminView($this);
        
    }
}
