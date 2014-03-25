<?php $cta = $this->getPageBlocks(1); // Call to action blocks
if (count($cta) > 0) {
    $size = 12 / count($cta); ?>
<div class="showcase">
    <div class="container">
        <div class="row">
            <?php foreach ($cta as $actionCall) { ?>
            <div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?>">
                <div class="showcase-item">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if ($actionCall->image != '') { ?><img src="<?php echo $this->basePath($actionCall->image); ?>" alt="" /><?php } ?>
                        </div>
                        <div class="col-md-8">
                            <?php echo $actionCall->content; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } // END FOR EACH $CTA ?>
        </div>
    </div>
</div>
<?php } ?>
