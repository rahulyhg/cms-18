
<?php if (Yii::app()->user->hasFlash('valuationrequest')): ?>

  <div class="flash-success">
    <?php echo Yii::app()->user->getFlash('valuationrequest'); ?>
</div>

<?php endif; ?>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'valuation-request-form',
  'enableClientValidation' => true,
  'enableAjaxValidation' => false,
  // 'clientOptions' => array(
  //   'validateOnSubmit' => true,
  //   ),
  )); ?>

  <table class="contactForm">
      <tbody><tr>
         <td style="width:120px;">Property Address:</td>
         <td>
            <?php echo $form->textField($model,'property_adress', array('maxlength'=>200,'class'=>'input')); ?>
            <?php echo $form->error($model,'property_adress'); ?>
        </td>
    </tr>
    <tr>
       <td>Property Type:</td>
       <td>
          <?php echo $form->dropDownList($model,'type_id', Propertytype::getDropDownPropertiesType(), array('empty'=>'All Property Types', 'class'=>'select-box')); ?>
          <?php echo $form->error($model,'type_id'); ?>
      </td>
  </tr>
  <tr>
     <td>Unit No:</td>
     <td class="unit-no">
        # <?php echo $form->textField($model,'unit_no_1', array('maxlength'=>200,'class'=>'input number_only')); ?>
        <?php echo $form->error($model,'unit_no_1'); ?>
        - <?php echo $form->textField($model,'unit_no_2', array('maxlength'=>200,'class'=>'input number_only')); ?>
        <?php echo $form->error($model,'unit_no_2'); ?>
    </td>
</tr>
<tr>
   <td>Size (sqft):</td>
   <td>
      <?php echo $form->textField($model,'size', array('maxlength'=>200,'class'=>'input number_only')); ?>
      <?php echo $form->error($model,'size'); ?>
  </td>
</tr>
<tr>
   <td>PES:</td>
   <td>
      <?php echo  $form->radioButtonList(
        $model,'pes',
        array(1=>'Yes',2=>'No'),
        array('separator'=>'', 
          'class'=>'radio',
          'labelOptions'=>array('style'=>'display:inline')
          ));
          ?>
      </td>
  </tr>
  <tr>
     <td>Owner's Name:</td>
     <td>
        <?php echo $form->textField($model,'owner_name', array('maxlength'=>200,'class'=>'input ')); ?>
        <?php echo $form->error($model,'owner_name'); ?>
    </td>
</tr>
<tr>
   <td>Owner's Mobile No:</td>
   <td>
      <?php echo $form->textField($model,'owner_mobile', array('maxlength'=>200,'class'=>'input number_only')); ?>
      <?php echo $form->error($model,'owner_mobile'); ?>
  </td>
</tr>
<tr>
   <td>Owner's Email:</td>
   <td>
     <?php echo $form->textField($model,'owner_email', array('maxlength'=>200,'class'=>'input')); ?>
     <?php echo $form->error($model,'owner_email'); ?>
 </td>
</tr>
<tr>
   <td>&nbsp;</td>
   <td><input type="submit" class="submit" value="Submit"></td>
   <td><input type="hidden" id="Valuationrequests[property_id]" name="Valuationrequests[property_id]" value="<?php echo $property_id ?>"></td>
</tr>
</tbody></table>

<?php $this->endWidget(); ?>


<style>
  .unit-no input{
    width: 90px !important;
}
</style>