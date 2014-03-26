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
            $this->startAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
        } catch (\Exception $e) {
            echo json_encode(Array('error' => $e->getMessage()));
        }
    }

    public function startAPI($request, $origin)
    {
        parent::process($request);
        if (!array_key_exists('apiKey', $this->request)) {
            throw new \Exception('No API Key provided');
        }
        echo $this->processAPI();
    }

    /**
     *
     * @return string
     */
    protected function page()
    {
        switch (strtolower($this->method)) {
            case "get":
                return $this->getPageData();
            case "put":
            case "post":
                return $this->updatePageData();
            default:
                return "Invalid Method call";
        }
    }

    private function getPageData()
    {
        return  $this->entityManager->getRepository("Sketch\Entities\Page")->get((int) $this->request['id']);
    }

    private function updatePageData()
    {
        $page   =  $this->entityManager->getRepository("Sketch\Entities\Page")->set((int) $this->request['id'],$this->request);
        if ($page) {
            return "Success";
        }

        return $this->_response("Page not found update: ".$e->getMessage(),404);
    }

    public function deploy()
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
            header("HTTP/1.1 401 Unauthorized");
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
