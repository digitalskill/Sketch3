<?php
namespace Sketch\Controllers;

/**
 * Load up a HTML layout, view, and Model page
 */
class IndexController extends Controller
{
    public $type = "text/html";

    /**
     * Display a HTML page view
     * @return \Sketch\Views\View
     */
    public function indexAction()
    {
        $this->getPage();

        return $this->view;
    }

    /**
     * @return \Sketch\Views\HTMLview
     */
    public function getPage()
    {
        $em     = \Sketch\Sketch::$instance->getEntityManager()
                    ->entityManager;
        $stub   = trim(join("/",\Sketch\Sketch::$instance->url));       // Get Landing page or sub page        
        if ($stub == "") {
            $p      = $em->getRepository("Sketch\Entities\Menu")
                    ->getLandingPage($_SERVER['HTTP_HOST']);            // Get Landing Page
        } else {
            $p      = $em->getRepository("Sketch\Entities\Menu")
                    ->getPageByStub($stub,$_SERVER['HTTP_HOST']);       // Get Page by Stub
        }
        if (!$p) {
            $p = $em->getRepository("Sketch\Entities\Menu")
                    ->getHoldingPage($_SERVER['HTTP_HOST']);
            if (!$p) {                
                \Sketch\Sketch::$instance->errors[] = "Page not Found";
                \Sketch\Sketch::$instance->status   = 404;
            }
        }
        if ($p) {
            \Sketch\Sketch::$instance->blocks = $em->getRepository("Sketch\Entities\Page")
                    ->getBlocks($p['page']['id']);
            \Sketch\Sketch::$instance->siteID = $p['site']['id'];
            \Sketch\Sketch::$instance->config = array_merge(\Sketch\Sketch::$instance->config,$p['site']);
            if ($p['page']['plugin'] != '') {
                $this->runPlugin($p['page']['plugin']);                 // Run the page plugin
            }
        }
        \Sketch\Sketch::$instance->node = $p;
        $this->view     = new \Sketch\Views\HtmlView($this);            // Load the view
    }
}
