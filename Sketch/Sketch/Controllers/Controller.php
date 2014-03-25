<?php
namespace Sketch\Controllers;
/**
 * Controller Class
 */
class Controller
{
    public static $instance;
    public $view    = "";
    public function __construct()
    {
        self::$instance =  $this;
        $view = $this->indexAction();
        $this->doHeaders();
        $this->compress();
        $view->render();
        $this->finish();
    }

    public function indexAction()
    {
        $this->sketch->errors[] = "You must create an Index action";
    }

    public function doHeaders()
    {
        if (\Sketch\Sketch::$instance->status == 200) {
            header( 'Vary: Accept-Encoding' );
            header( 'Content-Type: '.$this->type.'; charset=utf-8' );
            if (is_object(\Sketch\Sketch::$instance->getPageValues('updated'))) {
                $gmdate  = strtotime(\Sketch\Sketch::$instance->getPageValues('updated')->format("m/d/Y"));
                header( 'Last-Modified: ' . \gmdate( 'D, d M Y H:i:s',$gmdate ) . ' GMT' );
                header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( \time() + \Sketch\Sketch::$instance->getConfig('cacheseconds') ) ) . " GMT" );
                header( "Cache-Control: max-age=0, no-store, no-cache, private, must-revalidate" );
            } else {
                header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( time() - 3600 ) ) . " GMT" );
                header( "Cache-Control: max-age=" . \Sketch\Sketch::$instance->getConfig('cacheseconds') . ", private, must-revalidate" );
            }
        } else {
            $codes = \Sketch\Helpers\ErrorCodes::getCodes();
            header($_SERVER['SERVER_PROTOCOL'] . ' '.\Sketch\Sketch::$instance->status.' '.$codes[\Sketch\Sketch::$instance->status], true, \Sketch\Sketch::$instance->status);
        }
    }

    public function compress()
    {
        if (\Sketch\Sketch::$instance->status == 200 && \Sketch\Sketch::$instance->getConfig('compress') ) {
            if (extension_loaded('zlib')) {
                ob_start();
                ob_implicit_flush(0);
            } else {
                ob_start( "ob_gzhandler" );
            }
        }
    }

    public function finish()
    {
        if ( \Sketch\Sketch::$instance->getConfig('compress') && \Sketch\Sketch::$instance->status == 200 ) {
            ob_end_flush();
        }
    }
}
