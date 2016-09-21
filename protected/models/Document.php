<?php

/**
 * This is the model class for table "{{_documents}}".
 *
 * The followings are the available columns in table '{{_documents}}':
 * @property integer $id
 * @property string $document_name
 * @property string $document_file
 * @property string $created_date
 * @property integer $required_login
 * @property integer $status
 */
class Document extends _BaseModel
{

	public $maxUploadFileSize = 3145728;
	public $allowUploadType = 'doc,docx,xls,xlsx,pdf';
	public $uploadFileFolder = 'upload/files'; //remember remove ending slash;
	public $uploadFileFields = array('document_file');

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_documents}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('required_login, status', 'numerical', 'integerOnly' => true),
			array('document_name, document_file', 'length', 'max' => 255),
			array('document_name,document_file', 'required', 'on' => 'create, update'),
			array('document_file', 'file', 'on' => 'create,update',
				'allowEmpty' => true,
				'types' => $this->allowUploadType,
				'wrongType' => 'Only doc,docx,xls,xlsx,pdf are allowed.',
				'maxSize' => $this->maxUploadFileSize, // 3MB
				'tooLarge' => 'The file was larger than ' . ($this->maxUploadFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
			),
//		 array(
//						'document_file', 'match',
//						'pattern' => '/^[^\/?*:&;{}\\]+\.[^\/?*:;{}\\]{3}$/',
//						'message' => 'Uploaded files name cannot be included special characters: &%$#',
//					), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
            array('id, document_name,for_user_id, document_file, created_date, required_login, status', 'safe'),
			array('id, document_name,for_user_id, document_file, created_date, required_login, status', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'for_user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation', 'ID'),
			'document_name' => Yii::t('translation', 'Document Name'),
			'document_file' => Yii::t('translation', 'Document File'),
			'created_date' => Yii::t('translation', 'Created Date'),
			'required_login' => Yii::t('translation', 'Required Login'),
			'status' => Yii::t('translation', 'Status'),
            'for_user_id' => Yii::t('translation', "For User"),
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

		$criteria->compare('id', $this->id);
		$criteria->compare('document_name', $this->document_name, true);
		$criteria->compare('document_file', $this->document_file, true);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('required_login', $this->required_login);
		$criteria->compare('status', $this->status);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}
    
    public function searchFE($isPrivated = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('document_name', $this->document_name, true);
		$criteria->compare('document_file', $this->document_file, true);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('required_login', $this->required_login);
		$criteria->compare('status', $this->status);
        if ($isPrivated)
            $criteria->compare('for_user_id', Yii::app()->user->id);
        else
            $criteria->compare('for_user_id', 0);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}

	public function activate()
	{
		$this->status = 1;
		$this->update();
	}

	public function deactivate()
	{
		$this->status = 0;
		$this->update();
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
				$this->created_date = date('Y-m-d H:i:s');
		}
		return true;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Document the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function nextOrderNumber()
	{
		return Document::model()->count() + 1;
	}

}
