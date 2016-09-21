
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'Patient-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Blood Pressure Information</h3>
    </div>
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="form">
                <div class="row">
                    <div class="col-md-8 form-group form-group-sm">
                        <label  class="col-md-3"> Drugs  </label>      
                        <div class="col-md-9">
                            <input type="text"  class="form-control "/>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 form-group form-group-sm">
                        <label  class="col-md-3"> Blood Pressure  </label>      
                        <div class="col-md-9">
                            <select class="form-control">
                                <option value="1">Yes</option>
                                <option value="2">No</option>

                            </select>   
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 form-group form-group-sm">
                        <label  class="col-md-3">Comments  </label>      
                        <div class="col-md-9">
                            <textarea class="form-control"></textarea> 
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 form-group form-group-sm">
                        <label  class="col-md-3">Blood Pressure  </label>      
                        <div class="col-md-9">
                            <div class="date-of-birth">
                                <input type="text" class="form-control datepicker hasDatepicker" id="dp1430274047319">
                                <img class="ui-datepicker-trigger" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/icon_calendar_r.gif" alt="..." title="...">              
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 form-group form-group-sm">
                        <label  class="col-md-3">Time </label>      
                        <div class="col-md-9">
                            <div class="date-of-birth">
                                <input type="text" class="form-control datepicker hasDatepicker" id="dp1430274047319">
                                <img class="ui-datepicker-trigger" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/icon_calendar_r.gif" alt="..." title="...">              
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
