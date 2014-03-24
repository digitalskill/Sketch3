<?php $cta = $this->getPageBlocks(1); // Call to action blocks 
if(count($cta) > 0){ 
    $size = 12 / count($cta); ?>
<div class="showcase">
    <div class="container">
        <div class="row">
            <?php foreach($cta as $actionCall){ ?>
            <div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?>">
                <div class="showcase-item">
                    <?php echo $actionCall->content; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php } // END FOR EACH $CTA ?>
        </div>
    </div>
</div>
<?php } ?>