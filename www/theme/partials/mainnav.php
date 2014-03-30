<?php
$menuArray = $this->getMenu(2); // 0 = Get No Children - Top Level Only | 1 = get Top Level and their children | 2 = keep going to get all the depths needed
?>

<ul class="nav navbar-nav">
<?php
    foreach ($menuArray as $menu) {
        if ($menu['doMegaMenu']==1) {
            $this->partial("partials/megaMenu.php",array("menu"=>$menu));
        } else { ?>
            <li class="<?php echo (count($menu['__children']) > 0)? "dropdown" : ""; ?>">
                <a href="<?php echo $this->basePath($menu['path'])=="index"? "/" : $this->basePath($menu['path']); ?>"  <?php   if (count($menu['__children']) > 0) { ?> class="dropdown-toggle" data-toggle="dropdown"<?php } ?>>
                    <img src="<?php echo $this->basePath($menu['menuimage']); ?>" class="<?php echo $menu['menuclass']; ?>" alt="" />
                    <?php echo $menu['title']; ?>
                    <?php   if (count($menu['__children']) > 0) { ?>
                    <b class="caret"></b>
                    <?php } ?>
                </a>
            <?php   if (count($menu['__children']) > 0) { ?>
                <ul class="dropdown-menu ">
                    <li><a href="<?php echo $this->basePath($menu['path']); ?>"><?php echo $menu['title']; ?></a></li>
                <?php foreach ($menu['__children'] as $subMenu) { ?>
                    <li>
                        <a href="<?php echo $this->basePath($subMenu['path']); ?>">
                            <?php echo $subMenu['title']; ?>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            <?php   } ?>
            </li>
 <?php  }
    }?>
</ul>
