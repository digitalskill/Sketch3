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
        $this->view->layout = SKETCH_CORE."/".join("/",\Sketch\Sketch::$instance->url);
        return $this->view;
    }
    
    public function outputHeaders(){
        if(\Sketch\Sketch::$instance->status==200){
            header( 'Vary: Accept-Encoding' );
            header( 'Content-Type: '.$this->type.'; charset=utf-8' );
            header( 'Last-Modified: ' . \gmdate( 'D, d M Y H:i:s', \filemtime( $this->view->layout ) ) . ' GMT' );
            header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( \time() + \Sketch\Sketch::$instance->getConfig('cacheseconds')) ) . " GMT" );
            header( "Cache-Control: max-age=" . \Sketch\Sketch::$instance->getConfig('cacheseconds') . ", must-revalidate" );
            if ( isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) && ( \strtotime( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) == \filemtime( $this->view->layout ) ) ) {
                    header( 'HTTP/1.1 304 Not Modified' );
                    exit( );
            } 
        }
    }
}