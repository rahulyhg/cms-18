<style>
    .clickable {
        cursor: pointer;
    }
</style>
<?php
Yii::app()->clientScript->registerScript('search', "
    
        $('#inventory-grid .clickable').click(function()
        {
            var _id = $(this).parent().find('a.btn-status').attr('data-id');
            window.open('" . $this->createUrl('/inventories/update') . "?id='+ _id);
        });
        var index_href = '" . Yii::app()->createAbsoluteUrl('/inventories/index') . "';
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        
       
        $('.search-form form').submit(function(){
                var data = $(this).serialize();
                var url = $(this).attr('data-url');
             
                $.ajax({
                    'url': url,
                    'data': data,
                    'type': 'GET',
                    'dataType':'JSON',
                    success: function(r) {
                        if(r.code == 500) {
                           if(r.code_type == 'required') {
                                $('.Todate').html('To date cannot blank.');
                                $('.Fromdate').html('From date cannot blank.');
                                return false;
                           }
                           if(r.code_type == 'fromdate') {
                                $('.Fromdate').html(r.errors);
                                $('.Todate').html('');
                                return false;
                           }
                           else
                           {
                                $('.Todate').html(r.errors);
                                $('.Fromdate').html('');
                                return false;
                           }
                        }
                        else
                        {
                            
                            $('.Todate').html('');
                            $('.Fromdate').html('');
                         
                            $.fn.yiiGridView.update('inventory-grid', {
                                  url : $(this).attr('action'),
                                  data: data,
                                  
                           });
                        }
                        
                    }
                })
                
                
               
                            
                return false;
        });

        $('#clearsearch').click(function(){
                var id='search-form';
                var inputSelector='#'+id+' input, '+'#'+id+' select';
                $(inputSelector).each( function(i,o) {
                       if( $(o).attr('type')!= 'radio') {
                            $(o).val('');
                       }
                       
                });
                var data=$.param($(inputSelector));
                $.fn.yiiGridView.update('inventory-grid', {data: data});
                $('.Todate').html('');
                $('.Fromdate').html('');
                return false;
        });
        $('.btn-status').on('click',function(e){
                e.preventDefault();
                var data = $(this).attr('data-status');
                var text = 'Are you sure you want to Inactive Item?';
                if(data == 0) {
                    text = 'Are you sure you want to Active item?';
                }
                if (window.confirm(text))
                {
                       $.fn.yiiGridView.update('inventory-grid', {
                        type: 'POST',
                        url: $(this).attr('href'),
                        success: function() {
                         $.fn.yiiGridView.update('inventory-grid');
                            if(data == 0) { 
                              location.href =  location.href;
                            }
                            else
                            {
                                location.href =  index_href;
                            }
                        }
                        });
                        return false;
                }

                return false;
        });
        
        jQuery('#inventory-grid .delete-data').on('click',function(e){
                e.preventDefault();
                var text = 'Are you sure you want to delete item 1?';
                var status = $(this).attr('status');
                if( status == -1) {
                    text = 'Are you sure you want to recover item 1?';
                }
                if (window.confirm(text))
                {   
                        
                       $.fn.yiiGridView.update('inventory-grid', {
                        type: 'POST',
                        url: $(this).attr('href'),
                        success: function(data) {
                         $.fn.yiiGridView.update('inventory-grid');
                            if( status == -1 || status == 0) { 
                              location.href =  location.href;
                            }
                            else
                            {
                                location.href =  index_href;
                            }
                        }
                    });
                }

                return false;
        });
       
    ");
?>

<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Inventory') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add New Inventory'), array('/inventories/create'), array('class' => 'btn-1 pull-right ')); ?>
    </div>

    <div class=" box-body form-horizontal">
        <div class="row clearfix">
            <div class="col-md-12">

                <h4>Search </h4>
                <?php echo CHtml::link(Yii::t('translation', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
                <?php if ($show == 1): ?>
                    <div class='search-form'  style="display:block">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                <?php else: ?>
                    <div class='search-form' style="display:none">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">


                    <?php
                    //Yii::app()->clientScript;
                    $delete = '<i class="glyphicon glyphicon-remove"> </i>';
                    if ($status == -1) {
                        $delete = '<i class="glyphicon glyphicon-ok"> </i>';
                    }
                    $columnArray = array();

                    $hide = '';
//                    if ($show == 1) {
//                        $hide = 'hide';
//                    }
                    if ($patient == 1) {

                        $columnArray = array_merge($columnArray, array(
                            array(
                                'header' => 'S/N',
                                'type' => 'raw',
                                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                'headerHtmlOptions' => array('width' => '5%', 'style' => 'text-align:center;'),
                                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center;')
                            ),
                            array(
                                'header' => 'Brand name',
                                'name' => 'brand_name',
                            ),
                            array(
                                'header' => 'Per unit dosage',
                                'name' => 'per_unit_dosage',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Packing',
                                'name' => 'packing',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Price',
                                'name' => 'price_to_patient',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Warning',
                                'name' => 'warning',
                                'value' => '$data["warning"] == 1? "Yes" : "No" ',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Status',
                                'name' => 'status',
                                'value' => '$data["id"]',
                                'type' => 'statusInventory',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Created',
                                'name' => 'created',
                                'value' => 'date("d/m/Y",$data["created"])',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Actions',
                                'class' => 'CButtonColumn',
                                'htmlOptions' => array(
                                    'style' => 'width:6%',
                                ),
                                'template' => '{views} {updates} {deletes}',
                                'buttons' => array(
                                    'views' => array(
                                        'url' => 'Yii::app()->createAbsoluteUrl("/inventories/view",array("id"=>$data["id"]))',
                                        'options' => array('title' => 'View'),
                                        'label' => '<i class="glyphicon glyphicon-eye-open"> </i>',
                                    ),
                                    'updates' => array(
                                        'url' => 'Yii::app()->createAbsoluteUrl("/inventories/update",array("id"=>$data["id"]))',
                                        'options' => array('title' => 'Update'),
                                        'label' => '<i class="glyphicon glyphicon-pencil"> </i>',
                                    ),
                                    'deletes' => array(
                                        'url' => 'Yii::app()->createAbsoluteUrl("/inventories/delete",array("id"=>$data["id"]))',
                                        'options' => array(
                                            'title' => 'Delete',
                                            'class' => 'delete-data ' . $hide,
                                        ),
                                        'label' => '<i class="glyphicon glyphicon-remove"> </i>',
                                    ),
                                )
                            ),
                        ));
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'inventory-grid',
                            'dataProvider' => $model->searchByPatient(),
                            'filter' => null,
                            'pager' => array(
                                'header' => '',
                                'prevPageLabel' => 'Prev',
                                'firstPageLabel' => 'First',
                                'lastPageLabel' => 'Last',
                                'nextPageLabel' => 'Next',
                            ),
                            'selectableRows' => 2,
                            'columns' => $columnArray,
                        ));
                    } else {

                        $columnArray = array_merge($columnArray, array(
                            array(
                                'header' => 'S/N',
                                'type' => 'raw',
                                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                'headerHtmlOptions' => array('width' => '5%', 'style' => 'text-align:center;'),
                                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center;')
                            ),
                            array(
                                'header' => 'Brand name',
                                'name' => 'brand_name',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Per unit dosage',
                                'name' => 'per_unit_dosage',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Packing',
                                'name' => 'packing',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Price',
                                'name' => 'price_to_patient',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Warning',
                                'name' => 'warning',
                                'value' => '$data->warning == 1? "Yes" : "No" ',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Status',
                                'name' => 'status',
                                'value' => '$data->id',
                                'type' => 'statusInventory',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Created',
                                'name' => 'created',
                                'value' => 'date("d/m/Y",$data->created)',
                                'htmlOptions' => array('class' => 'clickable',)
                            ),
                            array(
                                'header' => 'Actions',
                                'class' => 'CButtonColumn',
                                'htmlOptions' => array(
                                    'style' => 'width:6%',
                                ),
                                'template' => '{views} {updates} {deletes}',
                                'buttons' => array(
                                    'views' => array(
                                        'url' => 'Yii::app()->createAbsoluteUrl("/inventories/view",array("id"=>$data->id))',
                                        'options' => array('title' => 'View'),
                                        'label' => '<i class="glyphicon glyphicon-eye-open"> </i>',
                                    ),
                                    'updates' => array(
                                        'url' => 'Yii::app()->createAbsoluteUrl("/inventories/update",array("id"=>$data->id))',
                                        'options' => array('title' => 'Update'),
                                        'label' => '<i class="glyphicon glyphicon-pencil" > </i>',
                                    ),
                                    'deletes' => array(
                                        'url' => 'Yii::app()->createAbsoluteUrl("/inventories/delete",array("id"=>$data->id))',
                                        'options' => array(
                                            'title' => $status != -1?'Delete':'Recover',
                                            'class' => 'delete-data ' . $hide,
                                            'status' => $status,
                                        ),
                                        'label' => $delete,
                                    ),
                                )
                            ),
                        ));
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'inventory-grid',
                            'dataProvider' => $model->search($status),
                            'filter' => null,
                            'pager' => array(
                                'header' => '',
                                'prevPageLabel' => 'Prev',
                                'firstPageLabel' => 'First',
                                'lastPageLabel' => 'Last',
                                'nextPageLabel' => 'Next',
                                'htmlOptions' => array('class' => 'pagination'),
                            ),
                            'selectableRows' => 2,
                            'columns' => $columnArray,
                        ));
                    }
                    ?>
                </div>
                <div class="col-md-12">
                    <p class="pull-right">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/inventories/index', array('status' => 1)); ?>">&#32; Active &#32;</a>||
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/inventories/index', array('status' => 0)); ?>"> &#32; Inactive &#32;</a> || 
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/inventories/index', array('status' => -1)); ?>"> &#32;Delete&#32; </a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$warning = Inventory::model()->getWarning();
$stockLow = Inventory::model()->getStockLow();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="flash_inventory">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">INVENTORY WARNING</h4>
            </div>
            <div class="modal-body" >
                <table class="table" >
                    <thead>
                    <th>Brand Name</th>
                    <th>Per unit dosage</th>
                    <th>Stock amount</th>
                    </thead>
                    <tbody>
<?php foreach ($warning as $item): ?>
                            <tr style="cursor: pointer;" class="inventory_warning_view" data-href="<?php echo Yii::app()->createAbsoluteUrl('/inventories/update?id=' . $item->id); ?>">
                                <td><?php echo $item->brand_name; ?></td>
                                <td><?php echo $item->per_unit_dosage; ?></td>
                                <td><?php echo $item->stock_amount_remainder; ?></td>
                            </tr>



<?php endforeach; ?>
<?php foreach ($stockLow as $item): ?>
                            <tr style="cursor: pointer;" class="inventory_warning_view" data-href="<?php echo Yii::app()->createAbsoluteUrl('/inventories/update?id=' . $item->id); ?>">
                                <td><?php echo $item->brand_name; ?></td>
                                <td><?php echo $item->per_unit_dosage; ?></td>
                                <td><?php echo $item->stock_amount_remainder; ?></td>
                            </tr>



<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var inventory_warning = false;
<?php if (count($warning) > 0 && $war == true) { ?>
        inventory_warning = true;
<?php } ?>


    var url_data_autocomplete_patient = "<?php echo Yii::app()->createAbsoluteUrl('/inventories/listPatient') ?>";
    Inventory.init();
    $(document).ready(function () {
        if (inventory_warning == true) {
            $('#flash_inventory').modal('show');
        }


        $(document).on('click', '.inventory_warning_view', function () {
            var elm = $(this);
            window.open(elm.attr('data-href'));
        });

    })


</script>
