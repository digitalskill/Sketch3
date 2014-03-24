<?php
// Create Site
$site = new \Sketch\Entities\Site();
$site->sitename     = 'Sketch';
$site->sitetagline  = "Welcome to Sketch CMS system";
$site->footertext   = "Sketch is built server first, for fast and flexible web sites";
$site->published    = 1;
$site->sitephone    = "000-111-1010";
$site->sitecountry  = "New Zealand";
$site->sitezip      = "3210";
$site->sitestate    = "Waikato";
$site->siteemail    = "sketchcms@sketchcms.co.nz";
$site->siteaddress  = "15 Address Place";
$site->domainname   = $_SERVER['HTTP_HOST'];
$site->themePath    = "theme";
$this->entityManager->persist($site);

// Create Banners
$banner = new \Sketch\Entities\Block();
$banner->heading    = "Sketch Banner";
$banner->image      = "/img/banner.jpg";
$banner->content    = '<img class="img-responsive" src="img/crown-white.png" alt=""><h2 class="white">General Info</h2>';
$banner->sort       = 0;
$banner->type       = 0;

$this->entityManager->persist($banner);


// Create Banners
$block = new \Sketch\Entities\Block();
$block->content    = '<img class="img-responsive" src="/img/fruit2.png" alt="" />
                        <h3><a href="#">Equine Porno Sumos</a></h3>
                        <p>Nam libero tempore, cum soluta nobis est minis voluptas assum simple and easy to distinguis quo.</p>';
$block->sort       = 0;
$block->type       = 1;

$this->entityManager->persist($block);

// Create Call To Actions
$block2 = new \Sketch\Entities\Block();
$block2->content    = '<img class="img-responsive" src="/img/fruit3.png" alt="" />
			<h3><a href="#">Equine Porno Sumos</a></h3>
			<p>Nam libero tempore, cum soluta nobis est minis voluptas assum simple and easy to distinguis quo.</p>';
$block2->sort       = 1;
$block2->type       = 1;

$this->entityManager->persist($block2);

// Create Page
$menu = new \Sketch\Entities\Menu();
$menu->setTitle("Home");
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
$menuPage->addBlock($banner);
$menuPage->addBlock($block);
$menuPage->addBlock($block2);

$this->entityManager->persist($menuPage);
$this->entityManager->persist($menu);

$about = new \Sketch\Entities\Menu();
$about->setTitle("About");
$aboutPage = new \Sketch\Entities\Page();
$aboutPage->title       = "About Page";
$aboutPage->description = "Welcome to Sketch";
$aboutPage->content     = "<h1>Welcome to Sketch About</h1>";
$aboutPage->edit        = "<h1>Welcome to Sketch About</h1>";
$about->page            = $aboutPage;
$about->site            = $site;
$about->doMegaMenu      = 1;
$about->menuclass       = "img-responsive";
$about->menuimage       = "img/nav-menu/nav2.jpg";
$aboutPage->addBlock($banner);
$aboutPage->addBlock($block);
$aboutPage->addBlock($block2);
$this->entityManager->persist($aboutPage);
$this->entityManager->persist($about);        


$contact = new \Sketch\Entities\Menu();
$contact->setTitle("Contact");
$contact->menuimage       = "img/nav-menu/nav3.jpg";
$contact->menuclass       = "img-responsive";
$contactPage = new \Sketch\Entities\Page();
$contactPage->title    = "Contact";
$contactPage->description = "Welcome to Sketch";
$contactPage->content   = "<h1>Welcome to Sketch Contact Page</h1>";
$contactPage->edit      = "<h1>Welcome to Sketch Contact Page</h1>";
$contact->page          = $contactPage;
$contact->site          = $site;

$this->entityManager->persist($contactPage);
$this->entityManager->persist($contact);

$gallery = new \Sketch\Entities\Menu();
$gallery->setTitle("Gallery");
$gallery->menuimage       = "img/nav-menu/nav4.jpg";
$gallery->menuclass       = "img-responsive";
$galleryPage = new \Sketch\Entities\Page();
$galleryPage->title    = "Gallery";
$galleryPage->description = "Welcome to Sketch";
$galleryPage->content   = "<h1>Welcome to Sketch Gallery</h1>";
$galleryPage->edit      = "<h1>Welcome to Sketch</h1>";
$gallery->page          = $galleryPage;
$gallery->site          = $site;

$this->entityManager->persist($galleryPage);
$this->entityManager->persist($gallery);

$shop = new \Sketch\Entities\Menu();
$shop->setTitle("Shop");
$shop->menuimage       = "img/nav-menu/nav5.jpg";
$shop->menuclass       = "img-responsive";
$shopPage = new \Sketch\Entities\Page();
$shopPage->title    = "Shop";
$shopPage->description = "Welcome to Sketch";
$shopPage->content   = "<h1>Welcome to Sketch Shop</h1>";
$shopPage->edit      = "<h1>Welcome to Sketch Shop</h1>";
$shop->page          = $shopPage;
$shop->site          = $site;

$this->entityManager->persist($shopPage);
$this->entityManager->persist($shop);

$this->entityManager->flush();