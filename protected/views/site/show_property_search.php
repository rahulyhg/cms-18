


<?php if (Yii::app()->user->hasFlash('propertysearch')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('propertysearch'); ?>
    </div>

<?php endif; ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'property-search-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
//         'clientOptions' => array(
//           'validateOnSubmit' => true,
//           ),
        ));
?>
<table class="contactForm">
    <tbody><tr>
            <td>Type:</td>
            <td>
                <?php echo $form->dropDownList($model, 'type_id', Propertytype::getDropDownPropertiesType(), array('empty' => 'All Property Types', 'class' => 'select-box')); ?>
                <?php echo $form->error($model, 'type_id'); ?>
            </td>
        </tr>
        <tr>
            <td>Location:</td>
            <td>
                <?php echo $form->textField($model, 'location', array('maxlength' => 200, 'class' => 'input')); ?>
                <?php echo $form->error($model, 'location'); ?>
            </td>
        </tr>
        <tr>
            <td>No. Of Bedrooms:</td>
            <?php
            for ($i = 1; $i <= 15; $i++) {
                $arr_num[$i] = $i;
            }
            ?>
            <td>
                <?php echo $form->dropDownList($model, 'min_bedroom', $arr_num, array('class' => 'select-box2')); ?>
                <?php echo $form->error($model, 'min_bedroom'); ?>
                <?php echo $form->dropDownList($model, 'max_bedroom', $arr_num, array('class' => 'select-box2')); ?>
                <?php echo $form->error($model, 'max_bedroom'); ?>
            </td>
        </tr>
        <tr>
            <td>Minimum Size:</td>
            <td>
<?php echo $form->textField($model, 'minimun_size', array('maxlength' => 200, 'class' => 'input number_only')); ?>
<?php echo $form->error($model, 'minimun_size'); ?>
            </td>
        </tr>
        <tr>
            <td>Budget:</td>
            <td>
<?php echo $form->textField($model, 'budget', array('maxlength' => 200, 'class' => 'input number_only')); ?>
<?php echo $form->error($model, 'budget'); ?>
            </td>
        </tr>
        <tr>
            <td>Tenure:</td>
            <td>
<?php echo $form->dropDownList($model, 'tenure_id', Tenures::getDropDownTenures(), array('class' => 'select-box')); ?>
<?php echo $form->error($model, 'tenure_id'); ?>
            </td>
        </tr>
        <tr>
            <td>Ready or Building Under Construction(BUC):</td>
            <td>
                <?php
                echo $form->radioButtonList(
                        $model, 'ready', array(1 => 'Ready', 2 => 'BUC'), array('separator' => '',
                    'class' => 'radio',
                    'labelOptions' => array('style' => 'display:inline')
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>Preferred Viewing Day and Time:</td>
            <td>
                    <?php $model->referred_view = empty($model->referred_view) ? NULL : DateHelper::toDateFormat($model->referred_view); ?>
                <div style="float:left;">
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $this->widget('CJuiDateTimePicker', array(
                        'language' => 'en-GB',
                        'model' => $model, //Model object
                        'attribute' => 'referred_view', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'options' => array('dateFormat' => 'dd/mm/yy',
                            'regional' => 'en_us',
                            //                                                'minDate'=> 0,
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                        // 'showOn' => 'button',
                        // 'buttonImage'=> Yii::app()->createAbsoluteUrl('themes/isa/images/ico-calendar.png'),
                        // 'buttonImageOnly'=> true,
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'input',
                            'style' => 'width:193px;z-index:9999;',
                            'readonly' => 'readonly',
                        ),
                    ));
                    ?> 	
                </div>
<?php echo $form->error($model, 'referred_view'); ?>
            </td>
        </tr>
        <tr>
            <td>Name:</td>
            <td>
<?php echo $form->textField($model, 'name', array('maxlength' => 200, 'class' => 'input')); ?>
<?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <td>Mobile No:</td>
            <td>
<?php echo $form->textField($model, 'mobile', array('maxlength' => 200, 'class' => 'input number_only', 'maxlength' => 15)); ?>
<?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
<?php echo $form->textField($model, 'email', array('maxlength' => 200, 'class' => 'input')); ?>
<?php echo $form->error($model, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="submit" value="Submit"></td>
            <td><input type="hidden" name="Propertysearch[property_id]" value="<?php echo $property_id ?>"></td>
        </tr>
    </tbody>
</table>
<!-- </form> -->

<?php $this->endWidget(); ?>

<style>
    #Propertysearch_ready label{
        margin-right: 5px;
    }
</style>