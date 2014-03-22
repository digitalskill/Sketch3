<?php
namespace Sketch\Controllers;

class AssetsController extends Controller{
    public $type = "text/css";
    
    public function indexAction(){
        $this->view     =   new \Sketch\Views\AssetView($this);
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
            case "png":
                $this->type = "image/png";
                break;
            case "jpg":
                $this->type = "image/jpg";
                break;
            case "gif":
                $this->type = "image/gif";
                break;
            case "woff":
                $this->type = "font/opentype";
                break;
            default :
                \Sketch\Sketch::$instance->status=404;
        } 
        $this->view->layout = SKETCH_CORE."/".join("/",\Sketch\Sketch::$instance->url); 
        if(!is_file($this->view->layout)){
           \Sketch\Sketch::$instance->status=404;
        }
        return $this;
    }
    
    public function render(){
        $this->doHeaders();
        $this->view->render();
    }
    
    public function doHeaders() {
        if(\Sketch\Sketch::$instance->status == 200){
            header( 'Vary: Accept-Encoding' );
            header( 'Content-Type: '.$this->type );
            header( 'Last-Modified: ' . \gmdate( 'D, d M Y H:i:s',filemtime( $this->view->layout )  ) . ' GMT' );
            header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( \time() + \Sketch\Sketch::$instance->getConfig('cacheseconds') ) ) . " GMT" );
            header( "Cache-Control: max-age=".\Sketch\Sketch::$instance->getConfig('cacheseconds') );
            if ( isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) && ( strtotime( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) >= filemtime( $this->view->layout ) ) && \Sketch\Sketch::$instance->getConfig('cache')==true ) {  
                header( 'HTTP/1.1 304 Not Modified' );
                exit( );
            }
        }else{
            $codes = \Sketch\Helpers\ErrorCodes::getCodes();
            header($_SERVER['SERVER_PROTOCOL'] . ' '.\Sketch\Sketch::$instance->status.' '.$codes[\Sketch\Sketch::$instance->status], true, \Sketch\Sketch::$instance->status);
            exit();
        }
    }
}