<?php
namespace Sketch\Controllers;

class ApiController extends \Sketch\Helpers\API{
    protected $User;

    
    public function __construct() {
        if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
        }

        try {
            $this->startAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
        } catch (\Exception $e) {
            echo json_encode(Array('error' => $e->getMessage()));
        }
    }
    
    public function startAPI($request, $origin){
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
    protected function page() {
        switch(strtolower($this->method)){
            case "get":
                return $this->getPageData();
            case "put":
            case "post":
                return $this->updatePageData();
            default:
                return "Invalid Method call";
        }
    }
    
    private function getPageData(){
        $em  = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        return  $em->getRepository("Sketch\Entities\Page")->get((int)$this->request['id']);
    }
    
    private function updatePageData(){
        $em     = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        $page   =  $em->getRepository("Sketch\Entities\Page")->get((int)$this->request['id'],\Doctrine\ORM\Query::HYDRATE_OBJECT);
        if($page){
            try{
                foreach($this->request as $key => $value){
                    if(stripos($key,"date") !== false){
                        $d = new \DateTime(strtotime($value)); // Expects mm/dd/yyyy or dd-mm-yyyy
                        $page->$key = $d;
                    }else{
                        if($key=="block"){
                            $block = $em->getRepository("Sketch\Entities\Block")->get((int)$value,\Doctrine\ORM\Query::HYDRATE_OBJECT);
                            $page->addBlock($block);
                        }else{
                            if($key=="updatedBy"){
                                $person = $em->getRepository("Sketch\Entities\User")->get((int)$value,\Doctrine\ORM\Query::HYDRATE_OBJECT);
                                $page->updatedBy = $person;
                            }else{
                                $page->$key = $value;
                            }
                        }

                    }
                }
                $em->persist($page);
                $em->flush($page);
                return "Success";
            }catch(\Exception $e){
                return $this->_response("Cannot update: ".$e->getMessage(),500);
            }
        }
        return "Page not found";
    } 
}