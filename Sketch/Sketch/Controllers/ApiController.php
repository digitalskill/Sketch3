<?php
namespace Sketch\Controllers;

class ApiController extends \Sketch\Helpers\API
{
    protected $User;

    public function __construct()
    {
        $this->entityManager = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
        }

        try {
            $request = $_REQUEST;
            $url     = \Sketch\Sketch::$instance->url;
            unset($url[0]);
            unset($url[1]);
            $request['request'] = join("/",$url);
            $this->startAPI($request,$_SERVER['HTTP_ORIGIN']);
        } catch (\Exception $e) {
            echo json_encode(Array('error' => $e->getMessage()));
        }
    }

    public function startAPI($request, $origin)
    {
        parent::process($request['request']);
        if (!array_key_exists('apiKey', $this->request)) {
            throw new \Exception('No API Key provided');
        }
        echo $this->processAPI();
    }

    /**
     *
     * @return string
     */
    protected function page($args)
    {
        switch (strtolower($this->method)) {
            case "get":
                return $this->getPageData($args);
            case "put":
            case "post":
                return $this->updatePageData($args);
            default:
                return "Invalid Method call";
        }
    }

    private function getPageData($args=0)
    {
        return  $this->entityManager->getRepository("Sketch\Entities\Page")->get((int) $args[0]);
    }

    private function updatePageData($args)
    {
        $page   =  $this->entityManager->getRepository("Sketch\Entities\Page")->set((int) $args[0],$this->request);
        if ($page) {
            return "Success";
        }

        return $this->_response("Page not found update: ".$e->getMessage(),404);
    }

    public function deploy($args='')
    {
        if (is_file(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php")) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($classes);
            include_once(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php");
            if (!unlink(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php")) {
                $this->_response("SITE SETUP - PLEASE DELETE THE SETUP FILE: ".SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php");
            }
        } else {
            try {
                $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
                $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
                $schemaTool->updateSchema($classes);
            } catch (\Exception $e) {
                return $this->_response(array("Cannot update database: ". $e->getMessage()),500);
            }

            return "Site has been setup - Databases updated";
        }

        return "Site has been setup";
    }

    public function updateDatabase()
    {
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
        try {
            $schemaTool->updateSchema($classes);
        } catch (\Exception $e) {
            return $this->_response("Cannot update database: ". $e->getMessage(),500);
        }
    }
}
