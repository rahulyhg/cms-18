<?php $this->beginContent('/layouts/main'); ?>
<h1 id="admin_title"><?php echo $this->title; ?></h1>
<?php if (!empty($this->menu)): ?>
    <div id="menubar">
        <?php
        $this->beginWidget('zii.widgets.CPortlet');
        $this->widget('zii.widgets.CMenu', array(
            'items'=>$this->menu,
            'htmlOptions'=>array('class'=>'operations'),
        ));
        $this->endWidget();
        ?>
        <div class="clr"></div>
    </div>
<?php endif; ?>
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>