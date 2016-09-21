<li id="li_<?php echo $data->id?>"<?php echo $data->completed ? ' class="notice-completed"' : '' ?>>
    <div class="check-wrap clearfix">
        <input class="notice-item" type="checkbox" name="noticeCompleted" value="<?php echo $data->id?>"<?php echo $data->completed?' checked':''?> onchange="toggleComplete(this,'<?php echo $data->id?>')"/>
        <label><b><?php echo $data->title ?></b> <span class="notice-author"> - By <?php echo User::model()->findByPk($data->user_id)->username; ?>, <?php echo date('d F Y',$data->created); ?></span> -
        	<?php echo CHtml::link(Yii::t('static','Edit'),array('notice/update','id'=>$data->id)) ?></label>
    </div>
    <p><?php echo $data->content ?></p>
</li>
