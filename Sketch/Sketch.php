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
        $this->clearCache();                    // Clear the cache if asked for
        $i = $this->route();                    // Route the URL
        $this->endMemory        = memory_get_usage(false) - START_MEMORY;
        $this->benchmark();
    }

    private function benchmark()
    {
        if (isset($_GET['benchmark'])) { ?>
            <script type="text/javascript">
                try {
                console.info("PHP Processing time:  <?php echo number_format((microtime(true)-START_TIME),3); ?> seconds");
                console.info("Sketch Start Memory: <?php echo number_format(START_MEMORY/1048576,10); ?> MB");
                console.info("Sketch End Memory: <?php echo number_format($this->endMemory/1048576,10); ?> MB");
                <?php if (function_exists("memory_get_peak_usage")) { ?>
                        console.info("Peak PHP Memory used: <?php echo number_format(memory_get_peak_usage()/1048576,10); ?> MB");
                <?php } ?>
                <?php foreach ($this->benchMarkItems as $k => $v) {?>
                    console.info("<?php echo $k;?>: <?php echo number_format($v,3); ?> Seconds");
                <?php } ?>
                } catch (e) {}
            </script>
        <?php
        }
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
        list($url,)         = explode("?",trim($_SERVER['REQUEST_URI'],"/"));        
        $this->url          = explode("/",trim($url,"/"));
        if($this->url[0]=="index.php"){
            array_shift($this->url);
        }    
        if(strtolower($this->url[0])==strtolower($this->getConfig('landingstub'))){
            header("location: /");
            exit;
        }
        switch (strtolower(trim($this->url[0]))) {
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
        if(strtolower($file)==strtolower($this->getConfig('landingstub'))){
            return "/";
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        if($this->getConfig('htaccess')==false){
            if(!is_file(SITE_ROOT.DIRECTORY_SEPARATOR.$file)){
                $file = "index.php/".$file;
            }
        }
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
        return isset($this->forms[$formname]) ?  $this->forms[$formname] : false;
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
