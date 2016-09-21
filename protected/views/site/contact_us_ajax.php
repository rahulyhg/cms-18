
<div class="contactFormContainer">                  
    <h2 class="box-heading">Enquiry Form</h2>
    <div class="contactFormWrapper">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'contact-us-form',
            // 'enableClientValidation' => true,
            'enableAjaxValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        <table class="contactForm">
            <tr>
                <td>Name:</td>
                <td>
                    <?php echo $form->textField($model,'name', array('maxlength'=>200,'class'=>'input','placeholder'=>'Name')); ?>
                    <?php echo $form->error($model,'name'); ?>
                </td>
                
            </tr>

            <tr>
                <td>Mobile:</td>
                <td>
                    <?php echo $form->textField($model,'contact_no', array('maxlength'=>200,'class'=>'input','placeholder'=>'Contact no'));?>
                    <?php echo $form->error($model,'contact_no'); ?>
                </td>
                
            </tr>

            <tr>
                <td>Email:</td>
                <td>
                    <?php echo $form->textField($model,'email', array('maxlength'=>200,'class'=>'input','placeholder'=>'Email Address'));?>
                    <?php echo $form->error($model,'email'); ?>
                </td>
                
            </tr>

            <tr>
                <td>Message:</td>
                <td>
                    <?php echo $form->textArea($model,'message', array('cols'=>50,'rows'=>5,'class'=>'textarea','placeholder'=>'Message'));?>
                    <?php echo $form->error($model,'message'); ?>
                </td>
                
            </tr>      

            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Submit" class="submit"></td>
            </tr>

        </table>                        
        
        <?php $this->endWidget(); ?>
    </div>
</div>
