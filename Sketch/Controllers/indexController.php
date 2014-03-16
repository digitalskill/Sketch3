<?php
namespace Sketch\Controllers;

class indexController extends Controller{
    public $type = "text/html";
    
    public function indexAction(){
        $this->getPage();
        return $this->view;
    }
    
    public function getPage(){
        $em     = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        $stub   = trim(join("/",\Sketch\Sketch::$instance->url));
        $r      = $em->getRepository("Sketch\Entities\Menu")->getPageByStub($stub);
        if($r==null){
            \Sketch\Sketch::$instance->errors[] = "Page not Found";
            \Sketch\Sketch::$instance->status   = 404;
        }else{
            \Sketch\Sketch::$instance->node = $r;
        }
    }
}