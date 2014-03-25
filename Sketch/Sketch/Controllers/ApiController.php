<?php
namespace Sketch\Controllers;

class ApiController extends \Sketch\Helpers\API
{
    protected $User;

    public function __construct()
    {
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
        $em  = \Sketch\Sketch::$instance->getEntityManager()->entityManager;

        return  $em->getRepository("Sketch\Entities\Page")->get((int) $this->request['id']);
    }

    private function updatePageData()
    {
        $em     = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        $page   =  $em->getRepository("Sketch\Entities\Page")->set((int) $this->request['id'],$this->request);
        if ($page) {
            return "Success";
        }
        return $this->_response("Page not found update: ".$e->getMessage(),404);
    }
}
