<?php $b = $this->getPageBlocks(0); 
    if(count($b)==1){
?>
<div class="banner padd" style="background-image:url(<?php echo $this->basePath($b[0]->image) ;?>)">
    <div class="container">
        <?php echo $b[0]->content; ?>
        <div class="clearfix"></div>
    </div>
</div>
<?php }elseif(count($b) > 1){
  $this->partial("partials/bannerfancy.php");  
} ?>
