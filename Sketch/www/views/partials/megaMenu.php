<li class="<?php if(count($this->menu['__children'])>0){?>dropdown hidden-xs<?php } ?>">
    <a href="<?php echo $this->basePath($this->menu['path']); ?>"  <?php   if(count($this->menu['__children']) > 0){ ?> class="dropdown-toggle" data-toggle="dropdown"<?php } ?>>
        <img src="<?php echo $this->basePath($this->menu['menuimage']); ?>" class="<?php echo $this->menu['menuclass']; ?>" alt="" />
        <?php echo $this->menu['title']; ?>
        <?php   if(count($this->menu['__children']) > 0){ ?>
        <b class="caret"></b>
        <?php } ?>
    </a>
    <?php if(count($this->menu['__children'])>0){ ?>
    <ul class="dropdown-menu dropdown-md">
        <li>
            <div class="row">
                <?php foreach($this->menu['__children'] as $submenu){ ?>
                    <div class="col-md-4 col-sm-6">
                            <div class="menu-item">
                                    <h3><?php echo $submenu['title']; ?></h3>
                                    <img src="<?php echo $this->basePath($submenu['menuimage']); ?>" class="<?php echo $submenu['menuclass']; ?>" alt="" />
                                    <p><?php echo $submenu['menuDescription']; ?></p>
                                    <a href="<?php echo $this->basePath($submenu['path']); ?>" class="btn btn-danger btn-xs">View Menu</a>
                            </div>
                    </div>
                <?php } ?>
            </div>
        </li>
    </ul>
</li>
<li class="dropdown visible-xs">
    <a href="<?php echo $this->basePath($this->menu['path']); ?>" class="dropdown-toggle" data-toggle="dropdown"> Menu <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <?php foreach($this->menu['__children'] as $submenu){ ?>
            <li><a href="<?php echo $this->basePath($submenu['path']); ?>"><?php echo $submenu['title']; ?></a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>