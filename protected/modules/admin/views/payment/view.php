<?php
$this->breadcrumbs=array(
	$this->pluralTitle => array('index'),
	'View ' . $this->singleTitle . ' : ' . $title_name,
);

$this->menu = array(
    array('label'=> $this->pluralTitle, 'url'=>array('index'), 'icon' => $this->iconList),	
    array('label'=> 'Update '. $this->singleTitle, 'url'=>array('update', 'id'=>$model->id)),
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);   

?>
<h1>View <?php echo $this->singleTitle . ' : ' . $title_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
//echo $this->renderControlNav();
?>
<br/>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> View Payemnt</h3>
	</div>
	<div class="box-body"> 
                   
                <div class="col-md-4" >
                    <div class="pay-inv">

                        <h4>Drug Alert</h4>
                        <?php
                        if (!empty($drugalert)) {

                            foreach ($drugalert AS $itemDrugAlert) {
                                ?>
                                <p><b><?php echo $itemDrugAlert->name.' - '.$itemDrugAlert->comment; ?></b></p>

                                <?php
                            }
                        }
                        ?>

                    </div>

                </div>
                <div class="col-md-4" >
                    <div  class="pay-inv-infor">
                        <h5> <u>PAYMENT INFORMATION </u></h4>
                        <p>Unpaid Bills (Outstanding amount) = <b id="bill-total"><?php echo  Yii::app()->format->prices($model->amount_due);?></b> </p>      
                        <p>Bill To : <u> <?php if (!empty($patientInfor)) echo $patientInfor['name'] ?> </u> </p>      

                    </div>

                </div>
                <div class="col-md-4" >
                    <div  class="pay-inv-infor">
                        <div class="row margintext">
                            <?php if (!empty($patientInfor)) { ?>
                                <div class="col-md-4"><b><?php echo $patientInfor['name']; ?></b></div>
                                <div class="col-md-4 aligncenter"><?php echo $patientInfor['identity']; ?></div>
                                <div class="col-md-4 alignright"><?php echo $patientInfor['age']; ?> Years <?php echo $patientInfor['gender']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?php if (!empty($patientInfor)) { ?>
                                <div class="col-md-8">
                                    <?php
                                    if (!empty($langueges)) {
                                        echo $langueges;
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4 alignright"><?php echo $patientInfor['doctor_name'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                
            </div>
            <br>
            <br/>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dispense-model-form',
                'enableClientValidation' => false,
                'enableAjaxValidation' => FALSE,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                    ));
            ?>
            <br>
            <?php echo $this->renderNotifyMessage(); ?>
            
            <div class="form-horizontal" style="margin-top: 150px;">
                <div class="col-md-12 form-group-sm">
                    <div>
                        <table class="table table-hover table-responsive table-bordered" data-example-id="hoverable-table" >
                            <thead>
                                <tr>
                                    <th style="width: 5%">S/N</th>
                                    <th style="width: 30%">Item Name</th>
                                    <th style="width: 10%">Price / Unit</th>
                                    <th style="width: 5%">Quantity</th>
                                    <th style="width: 10%">Price</th>
                                    <th style="width: 10%">Discount</th>
                                    <th style="width: 10%">Price After Discount</th>
                                    <th style="width: 15%">Total</th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody class="invoice-main">
                                <?php 
                                $number = 0;
                                foreach ($invoiceItem as $index =>  $item):?>
                                <tr class='clickable-row invoice-item' >
                                    <td class="number-td"><?php echo $index+1; ?></td>
                                    <td >
                                     <?php echo $item->item_name;?>
                                    </td >


                                    <td>
                                         <?php echo Yii::app()->format->prices($item->price)?>
                                    </td>
                                    <td>
                                         <?php echo $item->quantity;?>
                                    </td>
                                    </td>
                                    <td>
                                         <?php  echo Yii::app()->format->prices($item->price * $item->quantity) ;?>

                                    <td>
                                        <?php echo $item->discount_type == 1 ? $item->discount.' %' : '$ '.$item->discount; ?> 
                                    </td>
                                    <td>     
                                          <?php echo Yii::app()->format->prices($item->price_after_discount);?>
                                    </td>
                                    <td>      <?php echo Yii::app()->format->prices($item->total);?></td>
                                    <td class="remove"> </td>
                                </tr>
                                <?php endforeach;?>
                                
                            </tbody>
                           
                        </table>
                         

                    </div>
                </div>
            </div>
           
            <div class="form bottom-form">
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-7">

                    </div>
                    <div class="col-md-5 ">
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Subtotal  </label>      
                            <div class="col-md-4">
                                  <p> <?php echo Yii::app()->format->prices($model->subtotal);?></p>
                                         
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Discount  </label>      
                            <div class="col-md-4">
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-8">
                                       <p>  <?php echo $model->discount_type == 1 ? $model->discount.' %' : '$ '.$model->discount; ?> </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Amount after discount   </label>      
                            <div class="col-md-4">
                                 <p> <?php echo Yii::app()->format->prices( $model->amount_after_discount );?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Add GST 7%   </label>      
                            <div class="col-md-4">
                                  <p> <?php echo Yii::app()->format->prices( $model->add_gst ) ;?></p>
                                  
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Total with GST </label>      
                            <div class="col-md-4">
                                   <p> <?php echo Yii::app()->format->prices( $model->total_with_gst);?></p>
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Amount due </label>      
                            <div class="col-md-4">
                                   <p> <?php echo Yii::app()->format->prices( $model->amount_due);?></p>
                            </div>
                        </div>
                        <div class="col-md-12 form-group form-group-sm">
                            <label  class="col-md-8">Total received</label>       
                            <div class="col-md-4">
                                   <p> <?php echo Yii::app()->format->prices( $model->total_receive );?></p>
                            </div>
                        </div>
                    </div>
                    </div>

                
            </div>
                 <div class="well" style="margin-left: 10px; margin-right: 10px;">
<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>	</div>
            <?php $this->endWidget(); ?>
          
        </div>
 
</div>
