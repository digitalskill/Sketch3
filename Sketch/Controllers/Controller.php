<?php
namespace Sketch\Controllers;
/**
 * Controller Class
 */
class Controller{
    public static   $instance;
    public $view    = "";
    public function __construct() {
        $this->view     =   new \Sketch\Views\HTMLview($this);
        SELF::$instance =  $this;
        $this->indexAction()->render();
        $this->doHeaders();
    }

    public function indexAction(){
        $this->sketch->errors[] = "You must create an Index action";
    }
    
    public function doHeaders(){
        if(\Sketch\Sketch::$instance->status == 200){
            header( 'Vary: Accept-Encoding' );
            header( 'Content-Type: '.$this->type.'; charset=utf-8' );
            if (is_object(\Sketch\Sketch::$instance->getPageValues('updated'))) {
                $gmdate  = strtotime(\Sketch\Sketch::$instance->getPageValues('updated')->format("m/d/Y"));
                header( 'Last-Modified: ' . \gmdate( 'D, d M Y H:i:s',$gmdate ) . ' GMT' );
                header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( \time() + \Sketch\Sketch::$instance->getConfig('cacheseconds') ) ) . " GMT" );
                header( "Cache-Control: max-age=0, no-store, no-cache, private, must-revalidate" );
            }else {
                header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( time() - 3600 ) ) . " GMT" );
                header( "Cache-Control: max-age=" . \Sketch\Sketch::$instance->getConfig('cacheseconds') . ", private, must-revalidate" );
            }
        }else{
            $codes = \Sketch\Helpers\ErrorCodes::getCodes();
            header($_SERVER['SERVER_PROTOCOL'] . ' '.\Sketch\Sketch::$instance->status.' '.$codes[\Sketch\Sketch::$instance->status], true, \Sketch\Sketch::$instance->status);
        }
    }
}
