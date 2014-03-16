<?php echo $this->doctype(); ?>
<?php $this->partial('partials/header.phtml'); ?>
<div class="wrapper">
    <?php $this->partial('partials/top.phtml'); ?> 
    <?php $this->partial('partials/menu.phtml'); ?> 
    <?php $this->partial('partials/banner.phtml'); ?>
    <?php $this->partial('partials/breadcrumbs.phtml'); ?>
    <?php $this->partial('partials/content.phtml'); ?>
    <?php $this->partial('partials/blog.phtml'); ?>
    <?php $this->partial('forms/form.phtml'); ?> 
    <?php $this->partial('partials/actions.phtml'); ?>
    <?php $this->partial('partials/social.phtml'); ?> 
    <div class="push"></div>
</div>
<?php $this->partial('partials/footer.phtml'); ?> 