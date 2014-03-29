<div class="row">
     <div class="col-md-4 col-sm-5">
        <a href="<?php echo $this->basePath(); ?>">
            <div class="logo">
                <img class="img-responsive" src="<?php echo $this->basePath("img/logo.png");?>" alt="" />
                <h1><?php echo $this->getSiteValues('sitename');     ?></h1>
                <p><?php  echo $this->getSiteValues('sitetagline');  ?></p>
            </div>
        </a>
    </div>
    <div class="col-md-8 col-sm-7">
            <nav class="navbar navbar-default navbar-right" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                           <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                   <span class="sr-only">Toggle navigation</span>
                                   <span class="icon-bar"></span>
                                   <span class="icon-bar"></span>
                                   <span class="icon-bar"></span>
                           </button>
                        </div>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <?php $this->partial("partials/mainnav.php"); ?>
                            </div>
                     </div>
             </nav>
     </div>
</div>
