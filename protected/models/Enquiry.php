<?php

/**
 * This is the model class for table "{{_enquiries}}".
 *
 * The followings are the available columns in table '{{_enquiries}}':
 * @property string $id
 * @property string $company_name
 * @property string $contact_name
 * @property string $street_name
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property string $email
 * @property string $website
 * @property string $enquiry_date
 * @property string $part
 * @property string $project
 * @property string $sorting_services
 * @property string $system_intergration
 * @property string $assembly_services
 * @property string $retrofit
 * @property string $vision
 * @property string $eddy_current
 * @property string $laser
 * @property string $air_gage
 * @property string $inspection_solutions_development
 * @property string $portable_inspections_sorting_station
 * @property string $automates_sorting_system
 * @property string $imss_interlligent_multi_sorting_system
 * @property string $pcl_control
 * @property string $pc_control
 * @property string $motion_control
 * @property string $complete_custom_solutions
 * @property string $blue_print_attached
 * @property string $picture_attached
 * @property string $note
 */
class Enquiry extends _BaseModel
{

	public $maxImageFileSize = 3145728; //3MB
	public $allowImageType = 'jpg,gif,png';
	public $allowUploadType = 'doc,docx,xls,xlsx,pdf';
	public $uploadImageFolder = 'upload/enquiry'; //remember remove ending slash
	public $defineImageSize = array('blue_print_attached' => array(
													array('alias' => 'thumb1', 'size' => '435x318'),
												),
									'picture_attached' => array(
													array('alias' => 'thumb1', 'size' => '435x318'),
												),
									
	);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_enquiries}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, contact_name, street_name, city, country, phone, email, website, part, project, sorting_services, system_intergration, '
				. 'assembly_services, retrofit, vision, eddy_current, laser, air_gage, inspection_solutions_development, portable_inspections_sorting_station, '
				. 'automates_sorting_system, imss_interlligent_multi_sorting_system, pcl_control, pc_control, motion_control, complete_custom_solutions, '
				. 'blue_print_attached, picture_attached', 'length', 'max' => 255),
			array('company_name,contact_name,street_name,city,country,phone,email,enquiry_date,part', 'required', 'on' => 'create, update'),
			array('email', 'email', 'on' => 'create, update'),
			array('blue_print_attached,picture_attached', 'file', 'on' => 'create,update',
				'allowEmpty' => true,
				'types' => $this->allowImageType,
				'wrongType' => 'Only doc,docx,xls,xlsx,pdf are allowed.',
				'maxSize' => $this->maxImageFileSize, // 3MB
				'tooLarge' => 'The file was larger than ' . ($this->maxImageFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
			),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_name, contact_name, street_name, city, country, phone, email, website, enquiry_date, part, project, sorting_services, system_intergration, assembly_services, retrofit, vision, eddy_current, laser, air_gage, inspection_solutions_development, portable_inspections_sorting_station, automates_sorting_system, imss_interlligent_multi_sorting_system, pcl_control, pc_control, motion_control, complete_custom_solutions, blue_print_attached, picture_attached, note', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation', 'ID'),
			'company_name' => Yii::t('translation', 'Company Name'),
			'contact_name' => Yii::t('translation', 'Contact Name'),
			'street_name' => Yii::t('translation', 'Street Name'),
			'city' => Yii::t('translation', 'City'),
			'country' => Yii::t('translation', 'Country'),
			'phone' => Yii::t('translation', 'Phone'),
			'email' => Yii::t('translation', 'Email'),
			'website' => Yii::t('translation', 'Website'),
			'enquiry_date' => Yii::t('translation', 'Enquiry Date'),
			'part' => Yii::t('translation', 'Part'),
			'project' => Yii::t('translation', 'Project'),
			'sorting_services' => Yii::t('translation', 'Sorting Services'),
			'system_intergration' => Yii::t('translation', 'System Intergration'),
			'assembly_services' => Yii::t('translation', 'Assembly Services'),
			'retrofit' => Yii::t('translation', 'Retrofit'),
			'vision' => Yii::t('translation', 'Vision'),
			'eddy_current' => Yii::t('translation', 'Eddy Current'),
			'laser' => Yii::t('translation', 'Laser'),
			'air_gage' => Yii::t('translation', 'Air Gage'),
			'inspection_solutions_development' => Yii::t('translation', 'Inspection Solutions Development'),
			'portable_inspections_sorting_station' => Yii::t('translation', 'Portable Inspections Sorting Station'),
			'automates_sorting_system' => Yii::t('translation', 'Automates Sorting System'),
			'imss_interlligent_multi_sorting_system' => Yii::t('translation', 'Imss Interlligent Multi Sorting System'),
			'pcl_control' => Yii::t('translation', 'Pcl Control'),
			'pc_control' => Yii::t('translation', 'Pc Control'),
			'motion_control' => Yii::t('translation', 'Motion Control'),
			'complete_custom_solutions' => Yii::t('translation', 'Complete Custom Solutions'),
			'blue_print_attached' => Yii::t('translation', 'Blue Print Attached'),
			'picture_attached' => Yii::t('translation', 'Picture Attached'),
			'note' => Yii::t('translation', 'Note'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('company_name', $this->company_name, true);
		$criteria->compare('contact_name', $this->contact_name, true);
		$criteria->compare('street_name', $this->street_name, true);
		$criteria->compare('city', $this->city, true);
		$criteria->compare('country', $this->country, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('website', $this->website, true);
		$criteria->compare('enquiry_date', $this->enquiry_date, true);
		$criteria->compare('part', $this->part, true);
		$criteria->compare('project', $this->project, true);
		$criteria->compare('sorting_services', $this->sorting_services, true);
		$criteria->compare('system_intergration', $this->system_intergration, true);
		$criteria->compare('assembly_services', $this->assembly_services, true);
		$criteria->compare('retrofit', $this->retrofit, true);
		$criteria->compare('vision', $this->vision, true);
		$criteria->compare('eddy_current', $this->eddy_current, true);
		$criteria->compare('laser', $this->laser, true);
		$criteria->compare('air_gage', $this->air_gage, true);
		$criteria->compare('inspection_solutions_development', $this->inspection_solutions_development, true);
		$criteria->compare('portable_inspections_sorting_station', $this->portable_inspections_sorting_station, true);
		$criteria->compare('automates_sorting_system', $this->automates_sorting_system, true);
		$criteria->compare('imss_interlligent_multi_sorting_system', $this->imss_interlligent_multi_sorting_system, true);
		$criteria->compare('pcl_control', $this->pcl_control, true);
		$criteria->compare('pc_control', $this->pc_control, true);
		$criteria->compare('motion_control', $this->motion_control, true);
		$criteria->compare('complete_custom_solutions', $this->complete_custom_solutions, true);
		$criteria->compare('blue_print_attached', $this->blue_print_attached, true);
		$criteria->compare('picture_attached', $this->picture_attached, true);
		$criteria->compare('note', $this->note, true);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Enquiry the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function nextOrderNumber()
	{
		return Enquiry::model()->count() + 1;
	}

}
