<?php echo $this->doctype(); ?>
<!--[if lt IE 7]> <html class="ie6 oldie no-js"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie no-js"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie no-js"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="en">
<meta name="author" content="Sketch">
<meta name="robots" content="INDEX,FOLLOW">
<meta name="title" content="<?php echo $this->getMenuValues('title'); ?>">
<meta name="og:title" content="<?php echo $this->getMenuValues('title'); ?>">
<meta name="og:url" content="<?php echo $this->basePath($this->getMenuValues('path')); ?>">
<meta name="og:title" content="<?php echo $this->getMenuValues('title'); ?>">
<meta name="og:image" content="<?php echo $this->pageimage; ?>">
<meta name="og:description" content="<?php echo $this->description; ?>">
<meta name="og:type" content="webpage">
<meta name="keywords" content="<?php echo $this->keywords; ?>">
<meta name="description" content="<?php echo $this->description; ?>">
<link rel="canonical" href="<?php echo $this->basePath($this->getMenuValues('path')); ?>" />
<title><?php echo $this->title; ?></title> 
<link href="<?php echo $this->basePath("favicon.ico");?>" rel="shortcut icon" type="image/vnd.microsoft.icon">
<?php 
    echo $this->HeadLink()
                ->prependFile($this->basePath("css/import.css"))
                ->prependFile($this->basePath("Assets/Normalize/v1/css/normalize.css"))
                ->prependFile($this->basePath("Assets/Bootstrap/v1/css/bootstrap.min.css"))
                ->prependFile($this->basePath("Assets/Stickyfooter/v1/css/stickyfooter.css"))
                ->appendFile($this->basePath("Assets/Prettyphoto/v1/css/prettyphoto.css"))
                ->appendFile($this->basePath("Assets/Fontawesome/v1/css/font-awesome.min.css"))
                ->appendFile($this->basePath("css/less-style.css"))
                ->appendFile($this->basePath("css/style.css"))
                ->appendFile($this->basePath("Assets/Revolution/v1/css/settings.css"))
                ->appendFile($this->basePath("Assets/Flexslider/v1/css/flexslider.css"))
                ->minify();
    echo $this->headScript()
                ->appendFile($this->basePath("Assets/modernizr/v1/js/modernizr.js"));
?>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!--[if IE]><link rel="stylesheet" href="css/ie-style.css"><![endif]-->
</head>
<body>  
<?php //echo $this->partial('partials/analytics.phtml'); ?>  