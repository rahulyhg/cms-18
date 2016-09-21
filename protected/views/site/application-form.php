<div class="main">
    <div class="container">
        <div class="breadcrumb"><a href="<?php echo yii::app()->createAbsoluteUrl('/')?>">Home</a> / <a href="<?php echo Yii::app() -> createAbsoluteUrl('/site/sponsors');?>">Sponsors</a> / Application Form</div>

        <h1 class="title-page">Application Form for Sponsors</h1>
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'member-form',
                'enableAjaxValidation'=>false,
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                ),
        )); ?>
            <div class="box-3">
                    <div class="intro">
                        <h2>Agreement to Sponsor the SEAPEX Exploration Conference</h2>
                        <h3>15th - 17 th April 2015</h3>
                        <p>We, the undersigned company hereby agree to provide the sponsorship as indicated below and agree to pay for the same on presentation of invoice. Please email this form to SEAPEX at akitts@pcr.com.co Please note SEAPEX will also require a 'high definition' company logo upon confirmation of sponsorship i.e. 300 dpi, gif, tif or jpeg file..</p>
                    </div>  
                    <?php 
                        $this->widget('zii.widgets.CListView', array(
                                'dataProvider'=>$model,
                                'id'=>'sponsors',
                                'itemView'=>'sponsors/_sponsor',
                                'viewData' => array('checkedList' => $checkedList),
                                'summaryText'=>'', 
                                'ajaxUpdate' => true,
                                'template'=>'{summary}{items}',
                        )); 
                    ?>
                <h2 class="title-1">Company Information</h2>
                <div class="form-type">
                    <?php $this->renderPartial('sponsors/_sponsor_form', array('model'=>$sponsorsModel, 'form' => $form)); ?>
                </div>                    

                <h2 class="title-1">Sponsorship Information</h2>
                <div class="form-type">
                    <div class="in-row clearfix">
                        <label class="lb-2">Sponsor Item Name <span class="dot">:</span></label>
                        <div class="group-2 txt-info">
                            <strong id="sponsorItemName"></strong>
                        </div>
                    </div>
                    <div class="in-row clearfix">
                        <label class="lb-2">Sponsor Item Amount (SGD) <span class="dot">:</span></label>
                        <div class="group-2 txt-info">
                            <strong id="sponsorItemPrice" data-iprice="0"></strong>
                        </div>
                    </div>
                    <div class="in-row clearfix">
                        <label class="lb-2"><?php echo Yii::t('translation', $form->labelEx($sponsorsModel,'order_contributions', array('label' => 'Order Contributions ( SGD )'))); ?></label>
                        <div class="group-2">
                            <?php echo $form->textField($sponsorsModel,'order_contributions',array('size'=>50,'maxlength'=>50, 'class' => 'text', 'id' => 'orderContributions')); ?>
                            <?php echo $form->error($sponsorsModel,'order_contributions'); ?>
                        </div>
                    </div>
                    <div class="in-row clearfix">
                        <label class="lb-2"><?php echo Yii::t('translation', $form->labelEx($sponsorsModel,'total', array('label' => 'Total value of your sponsorship ( SGD )'))); ?></label>
                        <div class="group-2">
                            <?php echo $form->textField($sponsorsModel,'total',array('size'=>50,'maxlength'=>50, 'class' => 'text', 'id' => 'totalPrice', 'readonly' => 'true')); ?>
                            <?php echo $form->error($sponsorsModel,'total'); ?>
                        </div>
                    </div> 
                    
                    <div class="box-4 clearfix">
                            <div class="row">
                                <div class="col-sm-8 content">
                                    <h3>Sponsorship Entitlements</h3>
                                    <ul>
                                        <li>Company logo on all event materials and website.</li>
                                        <li>An advertising brochure insert (maximum 4 double-sided pages) in the conference registration bags (for sponsorship at S$9,630 and above only).</li>
                                        <li>A complimentary poster panel exhibition area at the conference (for sponsorship at S$9,630 and above only).</li>
                                    </ul>
                                    <p><span class="dot-red">*</span>A refundable deposit of SGD 500.000 be required from all sponsors requiring a poster panel - this will be refunded in full after the conference providing the poster panel is utilized. Please be sure to add this deposit to the sponsorship amount as without it we are unable to secure a poster panel for you.</p>
                                    <div class="licence clearfix">
                                        <div class="group-2">
                                            <?php echo $form->checkBox($sponsorsModel,'check_license'); ?>
                                        </div>
                                        <label class="lb-2">
                                            <?php echo Yii::t('translation', $form->labelEx($sponsorsModel,'check_license', array('label' => 'I read and agree Terms & Conditions'))); ?>
                                            <?php echo $form->error($sponsorsModel,'check_license'); ?>
                                        </label>
                                    </div>
                                    <div class="in-row clearfix">
                                        <label class="lb-2"><?php echo Yii::t('translation', $form->labelEx($sponsorsModel,'request_panel', array('label' => 'Request Poster Panel'))); ?></label>
                                        <div class="group-2">
                                            <?php echo $form->radioButtonList($sponsorsModel,'request_panel', array('0' => 'Yes', '1' => 'No'),array('separator'=>'<span class="separator"></span>')); ?>
                                            <?php echo $form->error($sponsorsModel,'request_panel'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 image">
                                    <img src="<?php echo Yii::app() -> createAbsoluteUrl('/')?>/themes/seapex/img/poster-panels.jpg" alt="image" class="img-responsive" />
                                    <p class="note">Complimentary Poster panel: 3 sections of 2.0 m by 0.9 m wide (each) with 2 spot lights & a table provided.</p>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="clearfix">
                    <input type="submit" class="btn-3" value="SUBMIT FORM" />
                </div>
            <?php $this->endWidget(); ?>
        </div>
                
    </div>  

</div>
<script>
    $(document).ready(function(){
        
        $sprice = 0;
        $tempPrice = 0;
        $table = $('#sponsors').find('table').each(function(){
           if($(this).find('input:checkbox').is(':checked')){
               $sname = $('<span>', {
                                    'id': $(this).attr('data-id')
                                   ,'text': $(this).attr('data-name')
                                    });
               $(this).find('input:checkbox').each(function(){
                   if($(this).is(':checked')){
                        $sprice = parseInt($sprice) + parseInt($(this).attr('data-price'));
                   }
               });
               $('#sponsorItemName').append($sname);
           }
        });
        $('#sponsorItemPrice').text($sprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#sponsorItemPrice').attr('data-iprice', $sprice);
        $('#totalPrice').val($sprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $tempPrice = $sprice;
        $('.btn-buy').on('change',function(){
            $id = $(this).closest('table').attr('data-id');
            $name = $(this).closest('table').attr('data-name');
            $sname = $('<span>', {
                                'id': $id
                               ,'text': $name
                                });
            $price = parseInt($(this).attr('data-price'));
            if($(this).is(':checked')){
                $price += parseInt($('#sponsorItemPrice').attr('data-iprice'));
                if($('#sponsorItemName').find('#'+$id+'').text() === ''){
                    $('#sponsorItemName').append($sname);
                }
            }else{
                $price -= parseInt($('#sponsorItemPrice').attr('data-iprice'));
                if(!$(this).closest('table').find('input:checkbox').is(':checked')){
                    $('#'+$id+'').remove();
                }
            }
            $('#sponsorItemPrice').text(Math.abs($price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#sponsorItemPrice').attr('data-iprice', Math.abs($price));
            $('#totalPrice').val(Math.abs($price));
            $tempPrice = Math.abs($price);
            totalprice();
        });
        
        $('#orderContributions').on('change', function(){
            totalprice();
            $(this).val($(this).val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        function totalprice(){
            $total = parseInt($tempPrice) + parseInt($('#orderContributions').val() !== '' ? $('#orderContributions').val() : '0');
            $('#totalPrice').val($total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
        
    });
</script>
<style>
    .separator{
        padding: 0 20px;
    }
    .required span{
        color: red;
    }
    .licence{
        
    }
    .licence > div{
        float: left;
        width: 3%;
        min-width: 20px;
    }
    .licence > label{
        width: 97%;
        float: right;
        text-align: left;
    }
    .errorMessage{
        color: red;
    }
</style>