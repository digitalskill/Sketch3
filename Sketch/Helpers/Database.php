<?php
namespace Sketch\Helpers;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Database{
    private $db = null;
    private $config;
    public $entityManager;
    public static $instance;
    private $isDevMode     = false;
    private $entityFiles   = '';
    
    /**
     * 
     */
    public static function run(){
       new Database(); 
    }
    /**
     * construct DB
     */
    public function __construct(){
        $m = \Sketch\Sketch::$instance;
        $this->entityFiles = array(SITE_ROOT."/".$m->getConfig('entityFiles'),SKETCH_CORE."/Entities");    
        $this->isDevMode   = $m->getConfig("devmode")? true : false;
        $this->getListeners();
        $this->init([
            'driver'=>  $m->getConfig("driver"),
            'user'=>    $m->getConfig("user"),
            'password'=>$m->getConfig("password"),
            'dbname'  =>$m->getConfig("dbname"),
            ]);
        SELF::$instance = $this;
    }
    
    /**
     * 
     * @param array $conn
     */
    public function init(array $conn){
        $this->config = Setup::createConfiguration($this->isDevMode);
        $this->driver = new AnnotationDriver(new AnnotationReader(), $this->entityFiles);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $this->config->setMetadataDriverImpl($this->driver);
        $this->entityManager = EntityManager::create($conn, $this->config,$this->listeners);
    }
    
    private function getListeners(){
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
    public function getEntityManager(){
        return $this->entityManager;
    }
    
    public function updateDatabase(){
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
        try{
            $schemaTool->updateSchema($classes);
        }catch(\Exception $e){
            die("Cannot update database: ". $e->getMessage());
        }
    }
    
    /**
     * 
     */
    public function buildDatabase(){
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
        try{
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($classes);
        }catch(\Exception $e){
            $schemaTool->updateSchema($classes);
        }
        
        // Create Site
        $site = new \Sketch\Entities\Site();
        $site->name = 'Sketch';
        $site->published = 1;
        $site->domainname = $_SERVER['HTTP_HOST'];
        $this->entityManager->persist($site);
        
        // Create Page
        $menu = new \Sketch\Entities\Menu();
        $menu->setTitle("home");

        $menuPage = new \Sketch\Entities\Page();
        $menuPage->description = "Welcome to Sketch";
        $menuPage->title    = "Home Page";
        $menuPage->content  = "<h1>Welcome to Sketch</h1>";
        $menuPage->edit     = "<h1>Welcome to Sketch</h1>";
        $menu->page = $menuPage;
        $menu->site = $site;
        
        $this->entityManager->persist($menuPage);
        $this->entityManager->persist($menu);
        
        $about = new \Sketch\Entities\Menu();
        $about->setTitle("About");
        $aboutPage = new \Sketch\Entities\Page();
        $aboutPage->title    = "About Page";
        $aboutPage->description = "Welcome to Sketch";
        $aboutPage->content = "<h1>Welcome to Sketch</h1>";
        $aboutPage->edit    = "<h1>Welcome to Sketch</h1>";
        $about->page = $aboutPage;
        $about->site = $site;
        $this->entityManager->persist($aboutPage);
        $this->entityManager->persist($about);
        
        $contact = new \Sketch\Entities\Menu();
        $contact->setParent($about);
        $contact->setTitle("Contact-us");
        $contactPage = new \Sketch\Entities\Page();
        $contactPage->title    = "Contact Page";
        $contactPage->description = "Welcome to Sketch";
        $contactPage->content = "<h1>Welcome to Sketch</h1>";
        $contactPage->edit    = "<h1>Welcome to Sketch</h1>";
        $contact->page = $contactPage;
        $contact->site = $site;
        
        $this->entityManager->persist($contactPage);
        $this->entityManager->persist($contact);
        
        /* CREATE DB */
        $this->entityManager->flush();
    }
}