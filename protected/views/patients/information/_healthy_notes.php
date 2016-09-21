
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Healthy Notes') ?></h3>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Sync Data from Devices'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'alert("Under construction")')); ?>
    </div>
    <div class="panel-body">
      <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="<?php echo $healthytype == 'height_weight' ? "active" : "" ?>">
            <?php echo CHtml::link(Yii::t('static', 'Height / Weight'), array('patients/healthynotes', 'patient_id' => $patient_id, 'healthytype' => 'height_weight'), array('class' => 'legend-custom pull-left')); ?>
        </li>
        <li class="<?php echo $healthytype == 'blood_pressure' ? "active" : "" ?>">
            <?php echo CHtml::link(Yii::t('static', 'Blood Pressure'), array('patients/healthynotes', 'patient_id' => $patient_id, 'healthytype' => 'blood_pressure'), array('class' => 'legend-custom pull-left')); ?>
        </li>
        <li class="<?php echo $healthytype == 'glucose' ? "active" : "" ?>">
            <?php echo CHtml::link(Yii::t('static', 'Glucose'), array('patients/healthynotes', 'patient_id' => $patient_id, 'healthytype' => 'glucose'), array('class' => 'legend-custom pull-left')); ?>
        </li>
      </ul>
      
      <?php
        switch ($healthytype) {
          case 'height_weight':
            $this->renderPartial('information/healthynotes/_height_weight', compact('model', 'patient_id', 'heightweight', 'blood_pressure', 'glucose'));  
            break;
          case 'blood_pressure':
            $this->renderPartial('information/healthynotes/_blood_pressure', compact('model', 'patient_id', 'heightweight', 'blood_pressure', 'glucose'));
            break;
          case 'glucose':
            $this->renderPartial('information/healthynotes/_glucose', compact('model', 'patient_id', 'heightweight', 'blood_pressure', 'glucose'));
            break;
        }
      ?>
    </div>
  </ul>
</div>
    