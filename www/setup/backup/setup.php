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
$site->siteemail    = "husko2006@gmail.com";
$site->siteaddress  = "15 Address Place";
$site->domainname   = $_SERVER['HTTP_HOST'];
$site->themePath    = "theme";
$site->landingstub  = "home";
$this->entityManager->persist($site);

// Create Blocks
$block = new \Sketch\Entities\Block();
$block->image      = '/img/fruit2.png';
$block->content    = '<h3><a href="#">Equine Porno Sumos</a></h3>
                     <p>Nam libero tempore, cum soluta nobis est minis voluptas assum simple and easy to distinguis quo.</p>';
$block->sort       = 0;
$block->type       = 1;

$this->entityManager->persist($block);

// Create Call To Actions
$block2 = new \Sketch\Entities\Block();
$block2->image      = '/img/fruit3.png';
$block2->content    = '<h3><a href="#">Equine Porno Sumos</a></h3>
            <p>Nam libero tempore, cum soluta nobis est minis voluptas assum simple and easy to distinguis quo.</p>';
$block2->sort       = 1;
$block2->type       = 1;

$this->entityManager->persist($block2);

// Create Call To Actions
$block3 = new \Sketch\Entities\Block();
$block3->image      = '/img/fruit3.png';
$block3->content    = '<h3><a href="#">Equine Porno Sumos</a></h3>
            <p>Nam libero tempore, cum soluta nobis est minis voluptas assum simple and easy to distinguis quo.</p>';
$block3->sort       = 2;
$block3->type       = 1;

$this->entityManager->persist($block3);

// Create Banners
$banner = new \Sketch\Entities\Block();
$banner->heading    = "Sketch Banner";
$banner->image      = "/img/banner.jpg";
$banner->content    = '<img class="img-responsive" src="/img/crown-white.png" alt=""><h2 class="white">General Info</h2>';
$banner->sort       = 0;
$banner->type       = 0;
$banner->addBlock($block2);
$banner->addBlock($block);
$banner->addBlock($block3);
$this->entityManager->persist($banner);

$banner2 = new \Sketch\Entities\Block();
$banner2->heading    = "Sketch Banner 2";
$banner2->content    = "<p>Weclome to Sketch</p>";
$banner2->image      = "/img/banner.jpg";
$banner2->sort       = 0;
$banner2->type       = 0;
$banner2->addBlock($block3);
$banner2->addBlock($block);

$this->entityManager->persist($banner2);

// Create Gallery Images
$block4 = new \Sketch\Entities\Block();
$block4->image      = '/img/fruit3.png';
$block4->content    = 'Gallery Image 1';
$block4->sort       = 0;
$block4->type       = 2;

$this->entityManager->persist($block4);

// Create Gallery Images
$block5 = new \Sketch\Entities\Block();
$block5->image      = '/img/fruit3.png';
$block5->content    = 'Gallery Image 2';
$block5->sort       = 1;
$block5->type       = 2;

$this->entityManager->persist($block5);

// Create Gallery Images
$block6 = new \Sketch\Entities\Block();
$block6->image      = '/img/fruit3.png';
$block6->content    = 'Gallery Image 3';
$block6->sort       = 2;
$block6->type       = 2;

$this->entityManager->persist($block6);

// Create Gallery Images
$block7 = new \Sketch\Entities\Block();
$block7->image      = '/img/fruit2.png';
$block7->content    = 'Gallery Image 4';
$block7->sort       = 3;
$block7->type       = 2;

$this->entityManager->persist($block7);

// Create Gallery Images
$block8 = new \Sketch\Entities\Block();
$block8->image      = '/img/fruit2.png';
$block8->content    = 'Gallery Image 5';
$block8->sort       = 4;
$block8->type       = 2;

$this->entityManager->persist($block8);

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
$menu->sort             = 0;
$menuPage->addBlock($banner);
$menuPage->addBlock($banner2);
$menuPage->addBlock($block);
$menuPage->addBlock($block2);
$menuPage->addBlock($block3);

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
$about->sort            = 1;
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
$contactPage->plugin    = "Contact";
$contact->sort          = 2;
$contact->page          = $contactPage;
$contact->site          = $site;

$this->entityManager->persist($contactPage);
$this->entityManager->persist($contact);

$thanks = new \Sketch\Entities\Menu();
$thanks->setTitle("Thankyou");
$thanks->menuimage       = "img/nav-menu/nav3.jpg";
$thanks->menuclass       = "img-responsive";
$thanksPage = new \Sketch\Entities\Page();
$thanksPage->title      = "Thank you";
$thanksPage->description = "Thank you";
$thanksPage->content   = "<h1>We have received your form and are reviewing it now.</h1><p>We will be in touch shortly</p>";
$thanksPage->edit      = "<h1>We have received your form and are reviewing it now.</h1><p>We will be in touch shortly</p>";
$thanks->page          = $thanksPage;
$thanks->site          = $site;
$thanks->sort          = 0;
$thanks->setParent($contact);

$this->entityManager->persist($thanksPage);
$this->entityManager->persist($thanks);

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
$gallery->sort          = 3;
$galleryPage->extensions = array("imagesAccross"=>4);
$galleryPage->addBlock($block4);
$galleryPage->addBlock($block5);
$galleryPage->addBlock($block6);
$galleryPage->addBlock($block7);
$galleryPage->addBlock($block8);

$this->entityManager->persist($galleryPage);
$this->entityManager->persist($gallery);

$shop = new \Sketch\Entities\Menu();
$shop->setTitle("Shop");
$shop->sort            = 4;
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

$subscribe = new \Sketch\Entities\Menu();
$subscribe->setTitle("Subscribe");
$subscribe->sort            = 1;
$subscribe->setParent($contact);
$subscribe->menuimage       = "img/nav-menu/nav5.jpg";
$subscribe->menuclass       = "img-responsive";
$subscribePage = new \Sketch\Entities\Page();
$subscribePage->title       = "Subscribe";
$subscribePage->plugin      = "Subscribe";
$subscribePage->description = "Welcome to Sketch";
$subscribePage->content     = "<h1>Thanks for subscribing</h1><p>We haved added you email to our contacts database</p>";
$subscribePage->edit        = "<h1>Thanks for subscribing</h1><p>We haved added you email to our contacts database</p>";
$subscribe->page            = $subscribePage;
$subscribe->site            = $site;

$this->entityManager->persist($subscribePage);
$this->entityManager->persist($subscribe);

$verify = new \Sketch\Entities\Menu();
$verify->setTitle("Verify");
$verify->sort            = 2;
$verify->setParent($contact);
$verify->menuimage       = "img/nav-menu/nav5.jpg";
$verify->menuclass       = "img-responsive";
$verifyPage = new \Sketch\Entities\Page();
$verifyPage->plugin      = "Subscribe";
$verifyPage->title       = "Verify";
$verifyPage->description = "Verify your email address";
$verifyPage->content     = "<h1>Please verify your email address</h1><p>For us to add you to our fantastic maillist - we need you to verify your email address first.</p><p>Please check your inbox and follow its instuctions to contine</p>";
$verifyPage->edit        = $verifyPage->content;
$verify->page            = $verifyPage;
$verify->site            = $site;

$this->entityManager->persist($verifyPage);
$this->entityManager->persist($verify);

$failed = new \Sketch\Entities\Menu();
$failed->setTitle("Failed");
$failed->sort            = 0;
$failed->setParent($verify);
$failed->menuimage       = "img/nav-menu/nav5.jpg";
$failed->menuclass       = "img-responsive";
$failedPage = new \Sketch\Entities\Page();
$failedPage->title       = "Verify";
$failedPage->description = "Verify your email address";
$failedPage->content     = "<h1>Sorry - That email and link combination cannot be found</h1><p>Please try to subscribe again. You must respond to the link within 24 hours.</p>";
$failedPage->edit        = $failedPage->content;
$failed->page            = $failedPage;
$failed->site            = $site;

$this->entityManager->persist($failedPage);
$this->entityManager->persist($failed);

$unsubscribe = new \Sketch\Entities\Menu();
$unsubscribe->sort            = 3;
$unsubscribe->setTitle("Unsubscribe");
$unsubscribe->setParent($contact);
$unsubscribe->menuimage       = "img/nav-menu/nav5.jpg";
$unsubscribe->menuclass       = "img-responsive";
$unsubscribePage = new \Sketch\Entities\Page();
$unsubscribePage->plugin      = "UnSubscribe";
$unsubscribePage->title       = "Unsubscribe";
$unsubscribePage->description = "Unsubscribe from website";
$unsubscribePage->content     = "<h1>We're sorry to see you go...</h1><p>You can always subscibe to our mailing list again..</p>";
$unsubscribePage->edit        = $unsubscribePage->content;
$unsubscribe->page            = $unsubscribePage;
$unsubscribe->site            = $site;

$this->entityManager->persist($unsubscribePage);
$this->entityManager->persist($unsubscribe);

$this->entityManager->flush();
