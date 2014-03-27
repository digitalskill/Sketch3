<?php 
$cta = $this->getPageBlocks(2); // Get Gallery Blocks
if (count($cta) > 0) { ?>
<div class="gallery">
    <div class="container">
        <div class="gallery-content">
            <div class="row">
                <?php foreach ($cta as $actionCall) { ?>
                    <div class="col-md-<?php echo $this->imagesAccross; ?> col-sm-<?php echo $this->imagesAccross; ?>">
                        <div class="element">
                            <img class="img-responsive img-thumbnail" src="<?php echo $this->basePath($actionCall->image); ?>" alt=""/>
                            <span class="gallery-img-hover"></span>
                            <a href="<?php echo $this->basePath($actionCall->image); ?>" class="gallery-img-link">
                                <i class="fa fa-search-plus hover-icon icon-left"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-link hover-icon icon-right"></i>
                            </a>
                        </div>
                    </div>
                <?php } // END FOR EACH $CTA ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>