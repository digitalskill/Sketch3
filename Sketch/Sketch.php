<?php
namespace Sketch;

/* Sketch
Created By: Kevin Dibble
Date First Created: 2009
Date Updated: 16 March 2014

Sketch is the core class to load to manage the site
*/
class Sketch {
    private $config         = null;
    public static $instance;
    private $controllers    = [];
    public  $errors         = [];
    public  $status         = 200;
    private $endMemory      = 0;
    
    /**
     * 
     * @param array $config
     */
    public function __construct(array $config){
        session_start();                        // Start the Session for the page
        ob_start("ob_gzhandler");
        $this->node             = (object)[];
        $this->node->updated    = new \DateTime();
        SELF::$instance         = $this;        // Record Instance of Sketch
        $this->config           = $config;      // Save configuration
        $this->deploy();                        // Create Website / update DB
        $i = $this->route();                    // Route the URL
        $this->endMemory       = memory_get_usage(false) - START_MEMORY;
        ob_end_flush();
        $this->benchmark();
    }
    
    private function benchmark(){
        if(isset($_GET['benchmark'])){
            ob_start("ob_gzhandler");
            ?>
            <script type="text/javascript">
                try{
                console.info("PHP Processing time:  <?php echo number_format((microtime(true)-START_TIME),3); ?> seconds");
                console.info("Sketch Start Memory: <?php echo number_format(START_MEMORY/1048576,10); ?> MB");
                console.info("Sketch End Memory: <?php echo number_format($this->endMemory/1048576,10); ?> MB");
                <?php if(function_exists("memory_get_peak_usage")){ ?>
                        console.info("Peak PHP Memory used: <?php echo number_format(memory_get_peak_usage()/1048576,10); ?> MB"); 
                <?php } ?>
                }catch(e){}
            </script>
        <?php
            ob_end_flush();
        }
    }
    
    /**
     * Route - Decides what controller should be loaded
     */
    private function route(){
        list($url,)         = explode("?",trim($_SERVER['REQUEST_URI'],"/"));
        $this->url          = explode("/",$url);  
        switch (strtolower(trim($this->url[0]))){
            case "assets":
                return $this->loadController("assets");
                break;
            case "files":
                return $this->loadController("files");
                break;
            case "upload":
                return $this->loadController("upload");
                break;
            case "download":
                return $this->loadController("download");
                break;
            case "images":
                return $this->loadController("images");
                break;
            case "files":
                return $this->loadController("files");
                break;
            default:
                return $this->loadController("index");
                break;
        }
    }
    
    /**
     * 
     */
    private function deploy(){
        if(isset($_GET['deploy'])){
            $em = $this->getEntityManager()->buildDatabase();
        }
    }
    
    /**
     * 
     * @return Sketch\Helpers\Database
     */
    public function getEntityManager(){
        if(!Helpers\Database::$instance){
            Helpers\Database::run(); 
        }
        return Helpers\Database::$instance;
    }
    
    /**
     * 
     * @param mixed $item
     * @return mixed
     */
    public function __get($item){
        return isset($this->$item)?$this->$item: false;
    }
    
    /**
     * 
     * @param string $item
     * @return string
     */
    public function getConfig($item){
        return isset($this->config[$item]) ? $this->config[$item] : false;
    }
    
    public function notFound(){
        $this->status       = 404;
    }
    
    /**
     * 
     * @param string $controller
     * @return object Sketch\Controllers\Controller
     */
    public function loadController($controller){
        $control = "\Sketch\Controllers\\".$controller."Controller";
        if(isset($this->controllers[$control])){
            $i = $this->controllers[$control];
            return $i::$instance;
        }else{
            $this->controllers[$control] = new $control(); 
            return $this->controllers[$control];
        }
    }
    
    /**
     * 
     * @param type $item
     * @return type
     */
    public function getMenuValues($item){
        return $this->node->$item;
    }
    
    /**
     * 
     * @param string $item
     * @return mixed
     */
    public function getPageValues($item){
        return isset($this->node->page->$item) ? $this->node->page->$item : false;
    }
} // END SKETCH CLASS