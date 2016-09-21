<?php $this->beginContent('//layouts/main'); ?>
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo $this->title; ?></h2>
            <?php foreach ($this->menu as $menu) {
                echo CHtml::link($menu['label'], $menu['url'], array('class'=>$menu['class']));
            }
            ?>
        </div>
        <div class="space-5">
            <?php echo $content; ?>
        </div>
    </div>
<?php $this->endContent(); ?>