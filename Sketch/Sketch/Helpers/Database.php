<?php
namespace Sketch\Helpers;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Database
{
    private $db = null;
    private $config;
    public $entityManager;
    public static $instance;
    private $isDevMode     = false;
    private $entityFiles   = '';

    /**
     *
     */
    public static function run()
    {
       new Database();
    }
    /**
     * construct DB
     */
    public function __construct()
    {
        $m = \Sketch\Sketch::$instance;
        $this->entityFiles = array(SKETCH_CORE.DIRECTORY_SEPARATOR."Sketch".DIRECTORY_SEPARATOR."Entities");
        $this->isDevMode   = $m->getConfig("devmode")? true : false;
        $this->getListeners();
        $this->init([
            'driver'=>  $m->getConfig("driver"),
            'user'=>    $m->getConfig("user"),
            'password'=>$m->getConfig("password"),
            'dbname'  =>$m->getConfig("dbname"),
            ]);
        self::$instance = $this;
    }

    /**
     *
     * @param array $conn
     */
    public function init(array $conn)
    {
        $this->config = Setup::createConfiguration($this->isDevMode,$_SERVER['HTTP_HOST']);
        $this->driver = new AnnotationDriver(new AnnotationReader(), $this->entityFiles);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $this->config->setMetadataDriverImpl($this->driver);

        if (isset($_GET['clearCache'])) {
            $cacheDriver = $this->config->getMetadataCacheImpl();
            if ($cacheDriver) {
                $cacheDriver ->deleteAll();
            }
        }

        $this->entityManager = EntityManager::create($conn, $this->config,$this->listeners);
    }

    private function getListeners()
    {
        // standard annotation reader
        $annotationReader       = new \Doctrine\Common\Annotations\AnnotationReader;

        // create event manager and hook preferred extension listeners
        $this->listeners = new \Doctrine\Common\EventManager();
        // gedmo extension listeners, remove which are not used

        // sluggable
        $sluggableListener = new \Gedmo\Sluggable\SluggableListener;
        // you should set the used annotation reader to listener, to avoid creating new one for mapping drivers
        $sluggableListener->setAnnotationReader($annotationReader);
        $this->listeners->addEventSubscriber($sluggableListener);
        // */

        // tree
        $treeListener = new \Gedmo\Tree\TreeListener;
        $treeListener->setAnnotationReader($annotationReader);
        $this->listeners->addEventSubscriber($treeListener);

        // loggable
        $loggableListener = new \Gedmo\Loggable\LoggableListener;
        $loggableListener->setAnnotationReader($annotationReader);
        $this->listeners->addEventSubscriber($loggableListener);

        // timestampable
        $timestampableListener = new \Gedmo\Timestampable\TimestampableListener;
        $timestampableListener->setAnnotationReader($annotationReader);
        $this->listeners->addEventSubscriber($timestampableListener);

        // sortable
        $sortableListener = new \Gedmo\Sortable\SortableListener;
        $sortableListener->setAnnotationReader($annotationReader);
        $this->listeners->addEventSubscriber($sortableListener);

        // mysql set names UTF-8
        $this->listeners->addEventSubscriber(new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit());
    }

    /**
     *
     * @return entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

}
