<?phpclass DoctorController extends FrontController {	/**	 * Index page	 */	public function actionTableTime() {		$c=new CDbCriteria;        $c->order='is_default desc, name';        $doctors = Doctor::model()->findAll($c);        $clinics = Clinic::model()->findAll();        $model = new DoctorTime;    	$doctor_id = $doctors[0]->id;    	$model->doctor_id = $doctor_id;        if (isset($_POST['DoctorTime'])) {        	$model->attributes = $_POST['DoctorTime'];        	$doctor_id = $model->doctor_id;        	if ($_POST['doctor_time_is_update'] == 0) {        		//print_r($model->attributes);	        	$model->save();	        }	        else {	        	$modelUpdate = DoctorTime::model()->findByPK($_POST['doctor_time_is_update']);	        	$modelUpdate->clinic_id = $model->clinic_id;	        	$modelUpdate->comment = $model->comment;	        	$modelUpdate->update();	        }        }        $data = DoctorTime::model()->getTableDataByDoctor($doctor_id);        $this->render('tableTime',array(            'doctors'=>$doctors,            'data' => $data,            'model' => $model,            'clinics' => $clinics,            'daysWeek' => HDateTime::model()->dayOfWeeks(),        ));	}	public function actionAjaxGetTableTemplate() {		if (isset($_POST['doctor_id'])) {			$data = DoctorTime::model()->getTableDataByDoctor($_POST['doctor_id']);			$this->renderPartial('table_template',array('data' =>$data));		}	}	public function actionAjaxGetDoctorTime() {		if(isset($_POST['time_id'])) {			$model = DoctorTime::model()->findByPK($_POST['time_id']);			$arr = array(				"id" => $model->id,				'doctor_id' => $model->doctor_id,				'clinic_id' => $model->clinic_id,				'day' => $model->day,				'time' => $model->time,				'comment' => $model->comment,			);			echo json_encode($arr);		}	}	public function renderTimeRow($data, $timeKey) {		ob_start();		?>		<?php foreach ($data as $key => $day): ?>			<td <?php echo empty($day[$timeKey]) ? '' : 'class="has-data"'; ?> >			<?php if (!empty($day[$timeKey])) : ?>				<?php foreach ($day[$timeKey] as $item):				if($item->clinic_id > 0) : ?>				<section class="cell-time" timeid="<?php echo $item->id; ?>" style="background: <?php echo $item->getColorCode(); ?>">					<div class="cell-time-content" ><?php echo $item->getContent(); ?></div>					<?php if (!empty($item->comment)) : ?>					<div class="cell-time-comment"><?php echo Yii::t('static', 'Comments: '); ?><i><?php echo $item->comment; ?></i></div>					<?php endif; ?>					<input type="hidden" name="DoctorTime[id]" value="<?php echo $item->id; ?>">				</section>				<?php else : ?>					<div timeid="<?php echo $item->id; ?>" class="cell-time-empty cell-time" style="background: #FFFFAA;"><?php echo Yii::t('static', 'Not working '); ?></div>					<?php if (!empty($item->comment)) : ?>					<div class="cell-time-comment" style="background: #FFFFAA;"><?php echo Yii::t('static', 'Comments: '); ?><i><?php echo $item->comment; ?></i></div>				<?php endif; endif; endforeach ?>			<?php else: ?>				<div class="cell-time-empty" style="background: #D7FFFF;"><?php echo DoctorTime::model()->getEmptyContent(); ?></div>			<?php endif; ?>			</td>		<?php endforeach ?>		<script type="text/javascript">			$(function(){				$('.has-data').click(function(event) {			         //alert($(this).attr('timeid'));			         $('td').removeClass('active');			         $(this).addClass('active');			         time_id = $(this).children('.cell-time').attr('timeid');			         url = $('#ajaxGetDoctorTime').val();			         $('#time-table-form').show();			          $.ajax({			            type: "POST",			            dataType: "json",			            url: url, //Relative or absolute path to response.php file			            data: {time_id: time_id},			            async: false,				        cache: false,				        timeout: 500,			            success: function(data) {			            	$('#loading2').hide();			                $('#DoctorTime_day').val(data.day);			                $('#DoctorTime_time').val(data.time);			                $('#DoctorTime_doctor_id').val(data.doctor_id);			                $('#DoctorTime_clinic_id').val(data.clinic_id);			                $('#DoctorTime_comment').val(data.comment);			                $('#doctor_time_is_update').val(data.id);			                $('#DoctorTime_time,#DoctorTime_day').attr('disabled', 'disabled');			            }			        });			     });			});		</script>		<?php		$html = ob_get_clean();		return $html;	}}