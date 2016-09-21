<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'queue-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    ));
    ?>
    <br/>
    <div class="form form-horizontal" style="margin-right:10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">INVENTORY DETAIL</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form form-horizontal">
                                <div class="col-md-4 col-sm-4">

                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'brand_name', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'brand_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'brand_name'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'per_unit_dosage', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'per_unit_dosage', array('class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'per_unit_dosage'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'generic_name', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'generic_name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'generic_name'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'packing', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'packing', array('class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'packing'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'sold_by', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'sold_by', array('class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'sold_by'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'phone'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'contact', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textArea($model, 'contact', array('cols' => "40", 'row' => "5", 'class' => '', 'style' => 'width: 100%;',)); ?>
                                            <?php echo $form->error($model, 'contact'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">



                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'price_to_patient', array('class' => 'col-sm-5 control-label', 'type' => 'number', 'step' => 'any')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'price_to_patient', array('class' => 'form-control', 'maxlength' => 255, 'step' => '0.01')); ?>
                                            <?php echo $form->error($model, 'price_to_patient'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'insurance_price', array('class' => 'col-sm-5 control-label', 'type' => 'number', 'step' => 'any')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'insurance_price', array('class' => 'form-control', 'maxlength' => 255, 'step' => '0.01')); ?>
                                            <?php echo $form->error($model, 'insurance_price'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'price_to_patient_gst', array('class' => 'col-sm-5 control-label', 'type' => 'number', 'step' => 'any')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'price_to_patient_gst', array('class' => 'form-control', 'maxlength' => 255, 'step' => '0.01')); ?>
                                            <?php echo $form->error($model, 'price_to_patient_gst'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'price_bought_amount', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'price_bought_amount', array('class' => 'form-control', 'maxlength' => 255, 'step' => '0.01')); ?>
                                            <?php echo $form->error($model, 'price_bought_amount'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'price_bought_amount_gst', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'price_bought_amount_gst', array('class' => 'form-control', 'maxlength' => 255, 'step' => '0.01')); ?>
                                            <?php echo $form->error($model, 'price_bought_amount_gst'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'expiry_Date', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">

                                            <?php $model->expiry_date = date('d/m/Y', $model->expiry_date); ?>
                                            <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'expiry_date',
                                                'attribute' => 'expiry_date',
                                                'model' => $model,
                                                'options' => array(
                                                    'dateFormat' => 'dd/mm/yy',
                                                    'altFormat' => 'dd/mm/yy',
                                                    'changeMonth' => true,
                                                    'changeYear' => true,
                                                ),
                                                'htmlOptions' => array('class' => 'form-control')
                                            ));
                                            ?>
                                            <?php echo $form->error($model, 'expiry_date'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'bonus', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textArea($model, 'bonus', array('cols' => "40", 'row' => "5", 'class' => '', 'style' => 'width: 100%;',)); ?>
                                            <?php echo $form->error($model, 'bonus'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'price_after_bonus', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->numberField($model, 'price_after_bonus', array('class' => 'form-control', 'maxlength' => 255, 'step' => '0.01')); ?>
                                            <?php echo $form->error($model, 'price_after_bonus'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'bought_date', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">

                                            <?php $model->bought_date = date('d/m/Y', $model->bought_date); ?>
                                            <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'bougth_date',
                                                'attribute' => 'bought_date',
                                                'model' => $model,
                                                'options' => array(
                                                    'dateFormat' => 'dd/mm/yy',
                                                    'altFormat' => 'dd/mm/yy',
                                                    'changeMonth' => true,
                                                    'changeYear' => true,
                                                ),
                                                'htmlOptions' => array('class' => 'form-control')
                                            ));
                                            ?>
                                            <?php echo $form->error($model, 'bought_date'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'stock_amount_bought', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'stock_amount_bought', array('class' => 'form-control numeric-control stock_bought', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'stock_amount_bought'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'stock_amount_used', array('class' => 'col-sm-5 control-label ')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'stock_amount_used', array('class' => 'form-control numeric-control stock_used', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'stock_amount_used'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'stock_amount_remainder', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textField($model, 'stock_amount_remainder', array('class' => 'form-control numeric-control stock_re', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'stock_amount_remainder'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'warning', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->dropDownList($model, 'warning', array(1 => 'Yes', 0 => 'No'), array('empty' => 'Select', 'class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'warning'); ?>
                                        </div>
                                    </div>
                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->dropDownList($model, 'status', array(1 => 'Active', 0 => 'Inactive'), array('empty' => 'Select', 'class' => 'form-control', 'maxlength' => 255)); ?>
                                            <?php echo $form->error($model, 'status'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group form-group-sm'>
                                        <?php echo $form->labelEx($model, 'comments', array('class' => 'col-sm-5 control-label')); ?>
                                        <div class="col-sm-7">
                                            <?php echo $form->textArea($model, 'comments', array('cols' => "40", 'row' => "5", 'class' => '', 'style' => 'width: 100%;',)); ?>
                                            <?php echo $form->error($model, 'comments'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">

                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">ATTACH FILE</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form form-horizontal">
                                <div class='form-group form-group-sm'>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-6">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <th>File</th>
                                            <th>Description</th>
                                            <th></th>
                                            </thead>
                                            <tbody id="image-main">
                                                <?php $number = 0; ?>
                                                <?php if (isset($fileInventory) && !empty($fileInventory)): ?>
                                                    <?php foreach ($fileInventory as $key => $file): ?>
                                                        <tr class="image-item">
                                                            <td class="col-md-5" title="Click to add file">
                                                                <input type="file" class="image-imageFile hide" name="Inventories[file][<?php echo $number ?>]" accept="*"/>
                                                                <a href="javascript:void(0)" class="click-file hide " title="Click to add file"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                                <p class="file-text-show"><?php echo $file->name; ?></p>
                                                            </td>
                                                            <td class="col-md-7">
                                                                <input type="text" value="<?php echo $file->id; ?>" class="image-id form-control hide" name="Inventory[file_id][<?php echo $number ?>]" />
                                                                <input type="text" value="<?php echo $file->description; ?>" class="image-description form-control" name="Inventory[file_description][<?php echo $number ?>]" />
                                                            </td>
                                                            <td style="width: 3%">
                                                                <div class="invoice-icon">
                                                                    <i class="glyphicon glyphicon-minus"></i>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $number += 1; ?>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr class="image-item">
                                                        <td class="col-md-5"  title="Click to add file">
                                                            <input type="file" class="image-imageFile hide" name="Inventory[file][<?php echo $number ?>]" accept="*" />
                                                            <a href="javascript:void(0)" class="click-file" title="Click to add file"><i style="font-size: 40px;" class="glyphicon glyphicon-file"></i></a>
                                                        </td>
                                                        <td class="col-md-7">
                                                            <input type="text" class="image-description form-control" name="Inventory[file_description][<?php echo $number ?>]" />
                                                        </td>
                                                        <td style="width: 3%">
                                                            <div class="invoice-icon">
                                                                <i class="glyphicon glyphicon-minus"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="col-sm-10 col-md-offset-1">
                                        <div class="invoice-icon">
                                            <i class="glyphicon glyphicon-plus" data-number="<?php echo $number + 1; ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="clr"></div>
    <br/>
    <br/>
    <?php echo CHtml::htmlButton($model->isNewRecord ? $this->iconCreate . ' Create' : $this->iconSave . ' Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
    <?php echo CHtml::htmlButton($this->iconCancel . ' Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . Yii::app()->createAbsoluteUrl('/inventories/index') . '\'')); ?>
</div>
<?php $this->endWidget(); ?>
</div>
<script type="text/javascript">





    /**
     inventory Module
     **/
    var Inventories = function () {

        // function image 

        var default_item = '';

        var addImage = function () {
            $('.glyphicon-plus').click(function () {
                var num = $(this).attr('data-number');
                var item = addItem(num);
                $('#image-main').append(item);
                $(this).attr('data-number', parseInt(num) + 1);
            });
        }
        var addItem = function (num) {
            var item = default_item.clone();
            item.find('.image-imageFile').attr('name', 'Inventory[file][' + num + ']');
            item.find('.click-file').removeClass('hide');
            item.find('.image-id').remove();
            item.find('.file-text-show').remove();
            item.find('.image-description').attr('name', 'Inventory[file_description][' + num + ']');
            item.find('.image-description').val('');
            return item;
            ;
        }
        $(document).on('change', 'input[type=file]', function () {
            var img = $(this).parents('tr').find('.click-file');
            // var tmppath = URL.createObjectURL(event.target.files[0]);
            console.info(event.target.files[0].name);
            img.html('<i style="font-size: 40px;" class="glyphicon glyphicon-file"></i><p>' + event.target.files[0].name + '<p>');
        });

        $(document).on('click', '.glyphicon-minus', function () {
            var id = $(this).parents('tr').find('.image-id').val();
            var this_value = $('#delete_image').val();
            $('#delete_image').val(this_value + ',' + id);
            $(this).parents('tr').remove();
        });

        var sortImage = function () {
            $(document).on('click', '.up, .down', function (e) {
                e.preventDefault();
                var row = $(this).parents("tr:first");
                if ($(this).is('.up')) {
                    row.insertBefore(row.prev());
                } else {
                    row.insertAfter(row.next());
                }
            })
        }

        var stock = function () {
            $(document).on('change', '.stock_bought,.stock_used', function () {
                var stock_bought = $('.stock_bought').val();
                var stock_used = $('.stock_used').val();
                var stock_re = $('.stock_re');
                var v = stock_bought - stock_used;
                if (isNaN(v)) {
                    v = 0;
                }
                stock_re.val(v);
            })
        }

        var FileClick = function () {
            $(document).on('click', '.click-file', function () {

                $(this).prev('.image-imageFile').trigger('click');
            })
        }
        // public functions
        return {
            //main function
            init: function () {
                default_item = $('.image-item').first().clone();
                addImage();
                FileClick();
                stock();

            }

        };
    }();

    Inventories.init();
</script>