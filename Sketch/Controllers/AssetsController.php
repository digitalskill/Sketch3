<?php
namespace Sketch\Controllers;

class AssetsController extends Controller{
    public $type = "";
    public function indexAction(){
        $url   = end(\Sketch\Sketch::$instance->url);
        $parts = explode(".",$url);
        $type  = end($parts);
        switch(strtolower($type)){
            case "js":
                $this->type = "application/javascript";
                break;
            case "css":
                $this->type = "text/css";
                break;
            default :
                $this->view->notFound();
        } 
        if(!is_file(SKETCH_CORE."/".join("/",\Sketch\Sketch::$instance->url))){
           \Sketch\Sketch::$instance->status==404; 
        }
        $this->view->layout = SKETCH_CORE."/".join("/",\Sketch\Sketch::$instance->url);
        return $this->view;
    }
    
    /**
     * 
     */
    public function doHeaders(){
        parent::doHeaders();
        if(\Sketch\Sketch::$instance->status==200){
            if ( isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) && ( \strtotime( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) == \filemtime( $this->view->layout ) ) ) {
                header( 'HTTP/1.1 304 Not Modified' );
                exit( );
            }
        }
    }
}