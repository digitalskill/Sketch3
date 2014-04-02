<?php
namespace Sketch;

/* Sketch
Created By: Kevin Dibble
Date First Created: 2009
Date Updated: 16 March 2014

Sketch is the core class to load to manage the site
*/
class Sketch
{
    public $config         = null;
    public static $instance;
    private $controllers    = [];
    public $errors         = [];
    public $status         = 200;
    private $endMemory      = 0;
    public $url            = '';
    public $node           = null;
    public $blocks         = [];
    public $benchMarkItems = [];
    public $forms          = [];
    /**
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        session_start();                        // Start the Session for the page
        self::$instance         = $this;        // Record Instance of Sketch
        $this->config           = $config;      // Save configuration
        if (isset($this->config['timezone']) && $this->config['timezone'] != '') {
            date_default_timezone_set($this->config['timezone']);
        }
        $this->clearCache();                    // Clear the cache if asked for
        $i = $this->route();                    // Route the URL
    }

    /**
     *
     */
    private function clearCache()
    {
        if (isset($_GET['clearCache'])) {
            $files = scandir(SKETCH_CORE.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR);
            foreach ($files as $file) {
                if ($file != ".." && $file != '.') {
                    unlink(SKETCH_CORE.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR.$file);
                }
            }
        }
    }

    /**
     * Route - Decides what controller should be loaded
     */
    private function route()
    {
        $uri                = str_replace($this->getConfig('ignoreFolder'),'',$_SERVER['REQUEST_URI']);
        list($url,)         = explode("?",trim($uri,"/"));
        $this->url          = explode("/",trim($url,"/"));
        if ($this->url[0]=="index.php") {
            array_shift($this->url);
        }
        if (count($this->url)==0 || (isset($this->url[0]) && strtolower($this->url[0])==strtolower($this->getConfig('landingstub')))) {
            header("location: /");
            exit;
        }
        switch (strtolower(trim($this->url[0]))) {
            case "admin":
                return $this->loadController("Admin");
            case "assets":
                return $this->loadController("Assets");
            case "api":
                return $this->loadController("Api");
            case "minifycss":
                return $this->loadController("Minifycss");
            case "minifyjs":
                return $this->loadController("Minifyjs");
            default:
                return $this->loadController("Index");
        }
    }
    /**
     *
     * @return Sketch\Helpers\Database
     */
    public function getEntityManager()
    {
        if (!Helpers\Database::$instance) {
            Helpers\Database::run();
        }

        return Helpers\Database::$instance;
    }

    /**
     *
     * @param  mixed $item
     * @return mixed
     */
    public function __get($item)
    {
        return isset($this->$item)?$this->$item: false;
    }

    /**
     *
     * @param  string $item
     * @return string
     */
    public function getConfig($item)
    {
        return isset($this->config[$item]) ? $this->config[$item] : $this->getSiteValues($item);
    }

    public function notFound()
    {
        $this->status       = 404;
    }

    /**
     *
     * @param  string $controller
     * @return object Sketch\Controllers\Controller
     */
    public function loadController($controller)
    {
        $control = "\Sketch\Controllers\\".$controller."Controller";
        if (isset($this->controllers[$control])) {
            $i = $this->controllers[$control];

            return $i::$instance;
        } else {
            $this->controllers[$control] = new $control();

            return $this->controllers[$control];
        }
    }

    /**
     *
     * @param  type $file
     * @return type
     */
    public function basePath($file='')
    {
        $file = trim($file,"/");
        if (strtolower($file)==strtolower($this->getConfig('landingstub'))) {
            return "/".trim($this->getConfig('addtourl')."/","/");
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        if ($this->getConfig('htaccess')==false) {
            if (!is_file(SITE_ROOT.DIRECTORY_SEPARATOR.$file)) {
                $file = "index.php/".$file;
            }
        }
        $file = $this->getConfig('addtourl') . $file;
        $domainName = $_SERVER['HTTP_HOST'].'/'.$file;

        return $protocol.$domainName;
    }

    /**
     *
     * @param  type $item
     * @return type
     */
    public function getMenuValues($item)
    {
        return isset($this->node[$item])? $this->node[$item] : false;
    }

    /**
     *
     * @param  type $item
     * @return type
     */
    public function getSiteValues($item)
    {
        return isset($this->node['site'][$item])? $this->node['site'][$item] : false;
    }

    /**
     *
     * @param  string               $formname
     * @return \Sketch\Helpers\Form
     */
    public function getForm($formname)
    {
        if (isset($this->forms[$formname])) {
            return $this->forms[$formname];
        } else {
            $pluginPath = "\Sketch\Plugins\\".$formname;
            if (class_exists($pluginPath)) {
                new $pluginPath();

                return $this->forms[$formname];
            } else {
                return false;
            }
        }
    }

    public function setForm($formname,$form)
    {
        $this->forms[$formname] = $form;
    }
    /**
     *
     * @param  string $item
     * @return mixed
     */
    public function getPageValues($item)
    {
        if (isset($this->node['page'][$item])) {
            return $this->node['page'][$item];
        }
        if (isset($this->node['page']["extensions"][$item])) {
            return $this->node['page']["extensions"][$item];
        }

        return null;
    }
} // END SKETCH CLASS
