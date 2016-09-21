<div class="box-1 add-new-patient add-new">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Add Company Medical') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-ban-circle"></span> Cancel and Back'), array('/patients/companymedical'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-floppy-disk"></span> Save'), array('/patients/companymedical'), array('class' => 'btn-1 pull-right')); ?>
    </div>
    <div class="box-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'Patient-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                ));
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Company Information</h3>
            </div>
            <div class="panel-body">
                <div class="form">

                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3"> Company Name  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3">Department  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3">Staff No  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3">Entitlement  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Medical Insurance Information</h3>
            </div>
            <div class="panel-body">
                <div class="form">

                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3"> Company Name  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3">Department  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3">Staff No  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <label  class="col-md-3">Entitlement  </label>      
                            <div class="col-md-9">
                                <input type="text"  class="form-control "/>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">File Attachments</h3>
            </div>
            <div class="panel-body">
                <div class="form">

                  
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <div class="input-patients">
                                <div class="form-group">
                                    <input type="file" name="referal_report[]" multiple="multiple" accept="image/*" />   
                                </div>
                            </div>
                            <div class="text-label">
                                <label>Insurance Card</label>      
                            </div>
                        </div>

                    </div>
                    <div class="row">
                         <div class="col-md-4 form-group form-group-sm">
                            <div class="input-patients">
                                <div class="form-group">
                                    <input type="file" name="referal_report[]" multiple="multiple" accept="image/*" />   
                                </div>
                            </div>
                            <div class="text-label">
                                <label>Insurance Referal letter</label>      
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group form-group-sm">
                            <div class="input-patients">
                                <div class="form-group">
                                    <input type="file" name="referal_report[]" multiple="multiple" accept="image/*" />   
                                </div>
                            </div>
                            <div class="text-label">
                                <label>Insurance Document A</label>      
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>


    </div>
</div>

