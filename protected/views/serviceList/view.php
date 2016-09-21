
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'View Price List: '.$model->name) ?></h2>
             <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit Price List'), array('/serviceList/update/id/'.$model->id), array('class' => 'btn-1 pull-right ')); ?>
        </div>

        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'queue-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                    ));
            ?>
            <br/>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Name:</label>
                        <div class="col-sm-7">
                         <?php echo $model->name;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Clinic price:</label>
                        <div class="col-sm-7">
                         <?php echo $model->clinic_price;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Insurance price:</label>
                        <div class="col-sm-7">
                         <?php echo $model->insurance_price;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Contract A  Price:</label>
                        <div class="col-sm-7">
                         <?php echo $model->ctr_price;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">XYZ Price:</label>
                        <div class="col-sm-7">
                         <?php echo $model->new_price;?>
                        </div>
                    </div>
                    
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Status:</label>
                        <div class="col-sm-7">
                            <?php if($model->status != -1):?>
                                <?php echo $model->status == 1 ? "Active" : 'Inactive';?>
                            <?php else:?>
                                <?php echo "Deleted"; ?>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Created:</label>
                        <div class="col-sm-7">
                         <?php echo date('Y/m/d',$model->created);?>
                        </div>
                    </div>
                </div>
                

            </div>

            <div class="clr"></div>
            <?php echo CHtml::htmlButton('<i class="glyphicon glyphicon-arrow-left"></i> ' . 'Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . Yii::app()->createAbsoluteUrl('/serviceList/index') . '\'')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>

</div>
</div>
