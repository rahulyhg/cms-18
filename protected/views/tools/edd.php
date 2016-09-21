<div class="box-1">

    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'EDD') ?></h2>
    </div>

    <div class=" box-body form-horizontal">
        <div class="col-md-8 col-sm-offset-2" id="myform">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-8">
                        <label class="col-md-2 leftlabel">Today </label>      
                        <div class="col-md-4">
                            <input type="text" readonly="true" value="<?php echo date('l d F Y') ?>" class="form-control "/>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <span class="type-appt"><?php echo CHtml::submitButton(Yii::t('static', 'Find EDD'), array('class' => 'btn btn-primary pull-right', 'onclick' => 'calculateEDD()')); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <fieldset class="minfieldsetheigh">
                            <legend>
                                <input type="radio" value="1" checked="true" name="baseon"/> Based on LMP Date
                            </legend>
                            <label  class="col-md-3">LMP Date </label>      
                            <div class="col-md-9">
                                <input type="text" style="width: 90%; display: inline" readonly="true" id="lmp-date" value="<?php echo date('d/m/Y') ?>" class="form-control my-datepicker-control"  />
                                
                            </div>
                        </fieldset>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <fieldset class="minfieldsetheigh">
                            <legend>
                                <input type="radio" value="2"  name="baseon"/> Based on status
                            </legend>
                            <div style=" margin-bottom: 40px;">
                                <label  class="col-md-3">Weeks </label>      
                                <div class="col-md-3">
                                    <select id="upWeek" class="form-control">
                                        <?php for($i=0; $i <= 40; $i++):?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php endfor; ?>
                                        
                                    </select>   
                                </div>
                                <label  class="col-md-3"> Days </label>      
                                <div class="col-md-3">
                                    <select id="upDay" class="form-control">
                                        <?php for($i=0; $i <= 30; $i++):?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php endfor; ?>
                                    </select>   
                                </div>
                            </div>
                            <label  class="col-md-3">On </label>      
                            <div class="col-md-9">
                                <input type="text" style="width: 90%; display: inline" readonly="true" id="base-status-date" value="<?php echo date('d/m/Y') ?>" class="form-control my-datepicker-control"  />
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="form-group form-group-sm">
                        <fieldset>
                            <legend>
                                Status
                            </legend>
                            <div class="col-md-6 form-group ">
                                <label  class="col-md-3">E.D.D </label>      
                                <div class="col-md-9">
                                    <input type="text" id="edd-date" readonly="true" value="" class="form-control my-dob-datepicker"  />
                                </div>
                            </div>
                            <div class="col-md-6  form-group">
                                <label  class="col-md-3  col-sm-offset-1">As of Today </label>      
                                <div class="col-md-8">
                                    <input type="text" readonly="true" value="<?php echo date('d F Y') ?>" class="form-control my-dob-datepicker"  />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <!--div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <fieldset>
                            <legend >
                                    Query On Date
                            </legend>
                            <label  class="col-md-12 leftlabel">Date </label>      
                            <div class="col-md-6">
                                <input type="text" value="<?php echo date('d F Y') ?>" class="form-control"  />
                            </div>
                            <div class="col-md-6">
                                <button class="btn-1">Find Status</button>
                            </div>
                            <label  class="col-md-12 leftlabel">Status</label>      
                            <div class="col-md-12">
                                <input type="text"  class="form-control"  />
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <fieldset>
                            <legend >
                                    Query On Status
                            </legend>
                            <label  class="col-md-3 leftlabel">Weeks </label>  
                            <label  class="col-md-9 leftlabel">Days</label>      
                            <div class="col-md-3">
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>   
                            </div>
                            <div class="col-md-3">
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <button class="btn-1">Find Status</button>
                            </div>
                            <label  class="col-md-12 leftlabel">The above status will attain on</label>   
                            <div class="col-md-12">
                                <input type="text" value="<?php echo date('d F Y') ?>" class="form-control"  />
                            </div>
                        </fieldset>
                    </div>
                </div-->
                
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>

<script>
    function calculateEDD()
    {
        var checkType = $("#myform input[type='radio']:checked").val();
        var startDate = '';
        if (checkType == 1)
        {
            startDate = $('#lmp-date').val();
        }
        else if (checkType == 2)
        {
            var week = $("#upWeek option:selected").val(); 
            var dayNum = $("#upDay option:selected").val();
            
            var totalDays = (parseInt(week)*7) + parseInt(dayNum);
            var onDate = $('#base-status-date').val();
            if (onDate != '')
            {
                var res = onDate.split("/");
                var on = new Date(res[2], res[1], res[0]);
                on.setDate(on.getDate() - totalDays);
                startDate = on.getDate() + '/' + on.getMonth() + '/' + on.getFullYear();
            }
        }
        findEdd(startDate);
    }
    
    function findEdd(lmpDate)
    {
        if (lmpDate != '')
        {
            var res = lmpDate.split("/");
            var d = new Date(res[2], res[1], res[0]);
            d.setYear(d.getFullYear() + 1);
            d.setMonth(d.getMonth() - 3);
            d.setDate(d.getDate() + 7);
            var tempMonth = String(d.getMonth());
            var eddMonth = tempMonth.length > 1 ? d.getMonth(): '0' + d.getMonth();
            var eddDate = d.getDate() + '/' + eddMonth + '/' + d.getFullYear();
            $('#edd-date').val(eddDate);
        }
    }
</script>