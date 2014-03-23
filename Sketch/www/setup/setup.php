<?php
// Create Site
$site = new \Sketch\Entities\Site();
$site->sitename     = 'Sketch';
$site->sitetagline  = "Welcome to Sketch CMS system";
$site->published    = 1;
$site->sitephone    = "0273461011";
$site->domainname   = $_SERVER['HTTP_HOST'];
$site->themePath    = "theme";
$this->entityManager->persist($site);

// Create Page
$menu = new \Sketch\Entities\Menu();
$menu->setTitle("home");
$menu->landing          = 1;
$menuPage = new \Sketch\Entities\Page();
$menuPage->description  = "Welcome to Sketch";
$menuPage->title        = "Home Page";
$menuPage->content      = "<h1>Welcome to Sketch</h1>";
$menuPage->edit         = "<h1>Welcome to Sketch</h1>";
$menu->page             = $menuPage;
$menu->site             = $site;
$menu->menuclass        = "img-responsive";
$menu->menuimage        = "img/nav-menu/nav1.jpg";
$this->entityManager->persist($menuPage);
$this->entityManager->persist($menu);

$about = new \Sketch\Entities\Menu();
$about->setTitle("About");
$aboutPage = new \Sketch\Entities\Page();
$aboutPage->title       = "About Page";
$aboutPage->description = "Welcome to Sketch";
$aboutPage->content     = "<h1>Welcome to Sketch</h1>";
$aboutPage->edit        = "<h1>Welcome to Sketch</h1>";
$about->page            = $aboutPage;
$about->site            = $site;
$about->doMegaMenu      = 1;
$about->menuclass       = "img-responsive";
$about->menuimage       = "img/nav-menu/nav2.jpg";
$this->entityManager->persist($aboutPage);
$this->entityManager->persist($about);        


$contact = new \Sketch\Entities\Menu();
$contact->setTitle("Contact");
$contact->menuimage       = "img/nav-menu/nav3.jpg";
$contact->menuclass       = "img-responsive";
$contactPage = new \Sketch\Entities\Page();
$contactPage->title    = "Contact";
$contactPage->description = "Welcome to Sketch";
$contactPage->content   = "<h1>Welcome to Sketch</h1>";
$contactPage->edit      = "<h1>Welcome to Sketch</h1>";
$contact->page          = $contactPage;
$contact->site          = $site;

$this->entityManager->persist($contactPage);
$this->entityManager->persist($contact);

$this->entityManager->flush();