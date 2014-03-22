<?php
namespace Sketch\Controllers;

class indexController extends Controller{
    public $type = "text/html";
    
    public function indexAction(){
        $this->getPage();
        return $this->view;
    }
    
    public function getPage(){
        $this->view     =   new \Sketch\Views\HTMLview($this);
        $em     = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        
        // Check that we have a site
        $s      = $em->getRepository("Sketch\Entities\Site")->getSite($_SERVER['HTTP_HOST']);       // Get Site

        if($s){
            // Get Landing page or sub page
            $stub   = trim(join("/",\Sketch\Sketch::$instance->url));
            if($stub == "" ){
                $p      = $em->getRepository("Sketch\Entities\Menu")->getLandingPage($s['domainname']);         // Get Landing Page
            }else{
                $p      = $em->getRepository("Sketch\Entities\Menu")->getPageByStub($stub,$s['domainname']);    // Get Page by Stub
            }
        }
        if(!$p || !$s){
            if($stub == "" ){
                $p = $em->getRepository("Sketch\Entities\Menu")->getHoldingPage($_SERVER['HTTP_HOST']);     
            }
            if(!$p){
                \Sketch\Sketch::$instance->errors[] = "Page not Found";
                \Sketch\Sketch::$instance->status   = 404;
            }
        }
        \Sketch\Sketch::$instance->node = $p;
    }
}