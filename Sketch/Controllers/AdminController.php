<?php
namespace Sketch\Controllers;

/**
 * Load up a HTML layout, view, and Model page
 */
class AdminController extends Controller
{
    public $type = "text/html";
    
    public function indexAction() {
        if(end(\Sketch\Sketch::$instance->url)=="admin" 
                || end(\Sketch\Sketch::$instance->url)=="setup"
                || end(\Sketch\Sketch::$instance->url)=="login"
                || isset($_SESSION['ch'])
                ){
            return new \Sketch\Views\AdminView($this);
        }
        header("HTTP/1.1 401 Unauthorized");
        exit();
        
    }
}
