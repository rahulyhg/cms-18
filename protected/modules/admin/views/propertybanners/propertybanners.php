<div class="modal-dialog" style="width: 100%; margin-top: 100px; height: 400px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
        </div>
        <div class="modal-body">
           
                <iframe  src="<?php echo Yii::app()->createAbsoluteUrl('/admin/Propertybanners/index/property_id/' . $property_id . '') ?>" style="width: 100%; margin-top: 10px;  height: 350px; border: 0px;" >

                </iframe>
            
        </div>

        <div class="modal-footer">
            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
        </div>
    </div>
</div> 

