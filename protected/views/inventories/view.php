
<div class="form-horizontal">
    <div class="box-1">
        <div class="title-box clearfix">
            <h2 class="title"><?php echo Yii::t('static', 'View Inventory: '.$model->brand_name) ?></h2>
             <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit Inventory'), array('/inventories/update/id/'.$model->id), array('class' => 'btn-1 pull-right ')); ?>
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
                <h4>Detail</h4>
                <div class="col-md-4 col-sm-4">
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Brand Name:</label>
                        <div class="col-sm-7">
                         <?php echo $model->brand_name;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Per Unit Dosage:</label>
                        <div class="col-sm-7">
                         <?php echo $model->per_unit_dosage;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Generic Name:</label>
                        <div class="col-sm-7">
                         <?php echo $model->generic_name;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Packing:</label>
                        <div class="col-sm-7">
                         <?php echo $model->packing;?>
                        </div>
                    </div>
                     <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Sold by:</label>
                        <div class="col-sm-7">
                         <?php echo $model->sold_by;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Contact:</label>
                        <div class="col-sm-7">
                         <?php echo $model->contact;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Phone:</label>
                        <div class="col-sm-7">
                         <?php echo $model->phone;?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                   
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Price to patient:</label>
                        <div class="col-sm-7">
                         <?php echo $model->price_to_patient;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Price to patient gst:</label>
                        <div class="col-sm-7">
                         <?php echo $model->price_to_patient_gst;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Price bought amount:</label>
                        <div class="col-sm-7">
                         <?php echo $model->price_bought_amount;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Price bought amount gst:</label>
                        <div class="col-sm-7">
                         <?php echo $model->price_bought_amount_gst;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Expiry date:</label>
                        <div class="col-sm-7">
                         <?php echo date('d/m/Y',$model->expiry_date);?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Bonus:</label>
                        <div class="col-sm-7">
                         <?php echo $model->bonus;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Price after bonus:</label>
                        <div class="col-sm-7">
                         <?php echo $model->price_after_bonus;?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Bought date:</label>
                        <div class="col-sm-7">
                         <?php echo date('d/m/Y',$model->bought_date);?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Stock amount bought:</label>
                        <div class="col-sm-7">
                         <?php echo $model->stock_amount_bought;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Stock amount used:</label>
                        <div class="col-sm-7">
                         <?php echo $model->stock_amount_used;?>
                        </div>
                    </div>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Stock amount remainder:</label>
                        <div class="col-sm-7">
                         <?php echo $model->stock_amount_remainder;?>
                        </div>
                    </div>
                    <?php if($model->warning == 1):?>
                    <div class='form-group form-group-sm'>
                        <label class="col-sm-5">Warning:</label>
                        <div class="col-sm-7">
                            <label class="warning btn-warning" style="width: 50px; text-align: center; border-radius:5px; padding: 2px;"><?php echo $model->warning == 1 ? " Yes" : 'No';?></label>
                        </div>
                    </div>
                    <?php else:?>
                        <div class='form-group form-group-sm'>
                            <label class="col-sm-5">Warning:</label>
                            <div class="col-sm-7">
                                <label><?php echo $model->warning == 1 ? " Yes" : 'No';?></label>
                            </div>
                        </div>
                    <?php endif;?>
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
                         <?php echo date('d/m/Y',$model->created);?>
                        </div>
                    </div>
                </div>
                

            </div>
             <?php
                    $fileInventory = InventoryFile::model()->findAll('inventory_id = :inventory',array(':inventory'=>$model->id));
                    if(!empty($fileInventory )):
              ?>
            <div class="row">
                <div class="col-md-12">
                    <h4>ATTACH FILE</h4>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th width="30%">File Name</th>
                                <th width="70%">Description</th>
                            </thead>
                            <tbody>
                              <?php foreach ($fileInventory as $item):?>
                                    <tr>
                                        <td><a  title="download file <?php echo $item->file;?>" href="<?php echo Yii::app()->createAbsoluteUrl('/').'/upload/files/inventory/'.$item->file;?>"><?php echo $item->name;?><a/></td>
                                        <td><?php echo $item->description;?></td>
                                    </tr>
                              <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <br/>
            <div class="clr"></div>
                           <?php echo CHtml::htmlButton('<i class="glyphicon glyphicon-arrow-left"></i> ' . 'Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . Yii::app()->createAbsoluteUrl('/inventories/index') . '\'')); ?>
 
        </div>
        <?php $this->endWidget(); ?>
    </div>

</div>
<?php if($model->warning == 1):?>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function(){ 
            if( $('.warning').hasClass('btn-warning'))
            {
                $('.warning').removeClass('btn-warning');
                $('.warning').addClass('btn-danger');
            }
            else
            {
                $('.warning').addClass('btn-warning');
                $('.warning').removeClass('btn-danger');
            }
            
        }, 500);
    })
</script>
<?php endif;?>