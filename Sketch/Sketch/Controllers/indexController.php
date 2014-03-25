<?php
namespace Sketch\Controllers;

class indexController extends Controller
{
    public $type = "text/html";

    public function indexAction()
    {
        $this->getPage();

        return $this->view;
    }

    public function getPage()
    {
        $em             = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        $s              = $em->getRepository("Sketch\Entities\Site")->getSite($_SERVER['HTTP_HOST']);           // Check that we have a site
        if ($s) {
            $stub   = trim(join("/",\Sketch\Sketch::$instance->url));                                           // Get Landing page or sub page
            \Sketch\Sketch::$instance->siteID = $s['id'];                                                       // Save the Site ID
            \Sketch\Sketch::$instance->config = array_merge(\Sketch\Sketch::$instance->config,$s);
            if ($stub == "") {
                $p      = $em->getRepository("Sketch\Entities\Menu")->getLandingPage($s['domainname']);         // Get Landing Page
            } else {
                $p      = $em->getRepository("Sketch\Entities\Menu")->getPageByStub($stub,$s['domainname']);    // Get Page by Stub
            }
        }
        if (!$p || !$s) {
            if ($stub == "") {
                $p = $em->getRepository("Sketch\Entities\Menu")->getHoldingPage($_SERVER['HTTP_HOST']);
            }
            if (!$p) {
                \Sketch\Sketch::$instance->errors[] = "Page not Found";
                \Sketch\Sketch::$instance->status   = 404;
            }
        }
        if ($p) {
            \Sketch\Sketch::$instance->blocks = $em->getRepository("Sketch\Entities\Page")->getBlocks($p['page']['id']);
        }
        \Sketch\Sketch::$instance->node     = $p;
        $this->view     = new \Sketch\Views\HTMLview($this);                                                    // Load the view

    }
}
