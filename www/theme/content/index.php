<?php function looper($item) {
        echo "<ul>";
        foreach ($item as $key => $value) {
            echo "<li>".$value["path"];
                if (count($value['__children']) > 0) {
                    looper($value['__children']);
                }
            echo "</li>";
        }
        echo "</ul>";
} ?>
<div class="general">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="general-content">
                    <div class="col-md-12 col-sm-12">
                        <?php echo $this->content; ?>
                        <?php looper($this->getMenu(100)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
