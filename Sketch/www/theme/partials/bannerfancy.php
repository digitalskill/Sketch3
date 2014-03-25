<?php $b = $this->getPageBlocks(0); 
        $imageSize = 350;
        $height = 500;
?>
<div class="tp-banner-container">
        <div class="tp-banner" >
        <ul>
            <?php foreach($b as $key => $banner){ ?>
            <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                <img src="<?php echo $this->basePath($banner->image); ?>"  alt=""  data-bgfit="cover" data-bgposition="center bottom" data-bgrepeat="no-repeat">

                <?php if($banner->heading != ''){ ?>
                    <div class="tp-caption lfl no-image bannerfont"
                            data-x="20" 
                            data-y="100"
                            data-speed="1500"
                            data-start="1200"
                            data-easing="Power4.easeOut"
                            data-endspeed="500"
                            data-endeasing="Power4.easeIn"
                            style="z-index: 3"><h1><?php echo $banner->heading ;?></h1>
                    </div>
                <?php } ?>
                
                <?php if($banner->content != ''){?>
                <div class="tp-caption lfl no-image bannerfont"
                        data-x="20"
                        data-y="200"
                        data-speed="1500"
                        data-start="1800"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power4.easeIn"
                        data-captionhidden="off"><h2><?php echo $banner->content ;?></h2>
                </div>
                <?php } ?>
                <?php $subbanner = $banner->getBlocks(); ?>
                
                <?php if(count($subbanner) > 0){
                     $startTopOffset = (($height - $imageSize) / count($subbanner)) / count($subbanner);
                    
                    foreach($subbanner as $k => $v){ ?>
                    <div class="tp-caption customin customout image<?php echo $imageSize; ?> whitebg"
                        data-x="right" data-hoffset="-<?php echo ($imageSize / count($subbanner)) * ($k); ?>"
                        data-y="<?php echo $startTopOffset + ($imageSize / count($subbanner)) * ($k) ?>"
                        data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                        data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                        data-speed="400"
                        data-start="<?php echo (count($subbanner) * 500)  * ($k); ?>"
                        data-easing="Power3.easeInOut"
                        data-endspeed="300"
                        style="z-index: 5">
                        <img class="slide-img img-responsive" src="<?php echo $this->basePath($v->image); ?>" width="<?php echo $imageSize; ?>" alt="" />
                    </div>
                <?php } // END FOR EACH ?>
                <?php } // END IF SUBBANNER > 0 ?>
            </li>
            <?php } ?>
        </ul>
        <div class="tp-bannertimer"></div>
    </div>
</div>