<?php
namespace Sketch\Controllers;

class MinifycssController extends Controller
{
    public $type    = "text/css";
    public $css     = "";
    public function indexAction()
    {
        $this->view         = $this;
        $this->cachePath    = SKETCH_CORE.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR.md5(join("/",\Sketch\Sketch::$instance->url)).".css";
        $this->createCache();

        return $this->view;
    }

    public function render()
    {
        if (\Sketch\Sketch::$instance->getConfig('cache')== true && is_file($this->cachePath)) {
            readfile($this->cachePath);
        } else {
            echo $this->css;
        }
    }

    public function createCache()
    {
        if (!is_file($this->cachePath) || \Sketch\Sketch::$instance->getConfig('cache')!= true) {
            $files = explode(":",str_replace("minifycss/","",join("/",\Sketch\Sketch::$instance->url)));
            foreach ($files as $file) {
                list($folder,) = explode("css/",$file);
                $checkcss = explode(".",$file);
                if (is_file(SKETCH_CORE.DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR.$file) && end($checkcss)=="css") {
                    $folder = \Sketch\Sketch::$instance->basePath("assets/".$folder);
                    $this->css .= str_replace("../",trim($folder,"/")."/",file_get_contents(SKETCH_CORE.DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR.$file));
                } elseif (is_file(SITE_ROOT.DIRECTORY_SEPARATOR.$file) && end($checkcss)=="css") {
                    $folder = trim(\Sketch\Sketch::$instance->getConfig("addtourl"),"/") . "/";
                    $this->css .= str_replace("../",$folder,file_get_contents(SITE_ROOT.DIRECTORY_SEPARATOR.$file));
                }
            }
            $this->css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', str_replace(': ', ':',preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $this->css)));
            if (\Sketch\Sketch::$instance->getConfig('cache') == true) {
                file_put_contents($this->cachePath,str_replace('; ',';',str_replace(' }','}',str_replace('{ ','{',str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),"",preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','', $this->css))))));
            }
        }
    }

    public function doHeaders()
    {
        if (\Sketch\Sketch::$instance->status == 200) {
            header( 'Vary: Accept-Encoding' );
            header( 'Content-Type: '.$this->type );
            if (is_file($this->cachePath) && \Sketch\Sketch::$instance->getConfig('cache') == true) {
                header( 'Last-Modified: ' . \gmdate( 'D, d M Y H:i:s',filemtime( $this->cachePath ) ) . ' GMT' );
                header( "Expires: " . \gmdate( "D, d M Y H:i:s", ( \time() + \Sketch\Sketch::$instance->getConfig('cacheseconds') ) ) . " GMT" );
                header( "Cache-Control: max-age=".\Sketch\Sketch::$instance->getConfig('cacheseconds') );
                if ( isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) && ( strtotime( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) >= filemtime( $this->cachePath ) ) && \Sketch\Sketch::$instance->getConfig('cache')==true ) {
                    header( 'HTTP/1.1 304 Not Modified' );
                    exit( );
                }
            }
        } else {
            header( 'Vary: Accept-Encoding' );
            header( 'Content-Type: '.$this->type );
            $codes = \Sketch\Helpers\ErrorCodes::getCodes();
            header($_SERVER['SERVER_PROTOCOL'] . ' '.\Sketch\Sketch::$instance->status.' '.$codes[\Sketch\Sketch::$instance->status], true, \Sketch\Sketch::$instance->status);
            exit( );
        }
    }
}
