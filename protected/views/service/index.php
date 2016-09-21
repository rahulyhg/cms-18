<h1>1. Get Patient List [POST]</h1>
<h3>View chart</h3>
get data: token, type (can be 0, 1, or 2. 0 means all charts)<br />
<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('service/getprojectchart', array('token'=>'xxx', 'type'=>0))?>"><?php echo Yii::app()->createAbsoluteUrl('service/ getprojectchart ', array('token'=>'xxx', 'type'=>0))?></a>
<br />
<br />
<h3>Get all</h3>
get data: token<br />
<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('service/getprojectlist', array('token'=>'xxx'))?>"><?php echo Yii::app()->createAbsoluteUrl('service/getprojectlist', array('token'=>'xxx'))?></a>
<br />
<br />
<h3>With search</h3>
get data: token, search keyword<br />
<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('service/getprojectlist', array('token'=>'xxx', 'search'=>'yyy'))?>"><?php echo Yii::app()->createAbsoluteUrl('service/getprojectlist', array('token'=>'xxx', 'search'=>'yyy'))?></a>
<hr />