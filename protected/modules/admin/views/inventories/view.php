<?php
$this->breadcrumbs = array(
    $this->pluralTitle => array('index'),
    'View ' . $this->singleTitle . ' : ' .$model->brand_name,
);

$this->menu = array(
    array('label' => $this->pluralTitle, 'url' => array('index'), 'icon' => $this->iconList),
    array('label' => 'Update ' . $this->singleTitle, 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);
?>
<h1>View <?php echo $this->singleTitle . ' : ' . $model->brand_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage();
//for list action button
echo $this->renderControlNav();
?><div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> View <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <?php
        
       
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'brand_name',
                'per_unit_dosage',
                'generic_name',
                'packing',
                'sold_by',
                'price_to_patient',
                'price_to_patient_gst',
                'price_bought_amount',
                array(
                    'name' => 'expiry_date',
                    'value' => date("Y/m/d",$model->expiry_date),
                    'type'=>'raw'
                ),
                array(
                    'name' => 'expiry_date',
                    'value' => date("Y/m/d",$model->bought_date),
                    'type'=>'raw'
                ),
                'stock_amount_bought',
                'stock_amount_used',
                'stock_amount_remainder',
                 array(
                    'name' => 'warning',
                    'type' => 'raw',
                     'value' =>'<label class="warning btn-warning">'. $model->warning ? "Yes" : "No".'</label>',
                ),
                array(
                    'name' => 'contact',
                    'type' => 'html',
                ),
                'phone',
                 array(
                    'name' => 'comments',
                    'type' => 'html',
                ),
                 array(
                    'name' => 'bonus',
                    'type' => 'html',
                ),
                 array(
                    'name' => 'created',
                    'value' => date("Y/m/d",$model->created),
                    'type'=>'raw'
                ),
                array(
                    'name' => 'updated',
                    'value' => date("Y/m/d",$model->updated),
                    'type'=>'html'
                ),
            ),
        ));
        ?>
        <?php
                    $fileInventory = InventoryFile::model()->findAll('inventory_id = :inventory',array(':inventory'=>$model->id));
                    if(!empty($fileInventory )):
              ?>
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-left: 20px;">ATTACH FILE</h4>
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
        <div class="well">
<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>	</div>
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