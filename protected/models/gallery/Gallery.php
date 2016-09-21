<?php

/**
 * This is the model class for table "{{_galleries}}".
 *
 * The followings are the available columns in table '{{_galleries}}':
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $brief_description
 * @property integer $category_id
 * @property integer $release_in_country
 * @property string $fileurl
 * @property string $rating_1
 * @property string $rating_2
 * @property integer $status
 * @property string $created_date
 * @property integer $posted_by
 */
class Gallery extends _BaseModel
{

	public $maxImageFileSize = 3145728; //3MB
	public $allowImageType = 'jpg,gif,png';
	public $uploadImageFolder = 'upload/galleries'; //remember remove ending slash
	public $defineImageSize = array(
								'fileurl' => array(
													array('alias' => 'thumb1', 'size' => '163x140'),
													array('alias' => 'photo', 'size' => '630x320')),
								);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_galleries}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section, status, posted_by', 'numerical', 'integerOnly' => true),
			array('title, slug, fileurl, youtubeurl', 'length', 'max' => 300),
			array('title, section, status', 'required', 'on' => 'create,update,photos,videos, updatevideo,updatephoto'),
			array('fileurl', 'required', 'on' => 'photos,updatephoto'),
			array('youtubeurl', 'required', 'on' => 'videos,updatevideo'),
			array('fileurl', 'file', 'on' => 'create,update',
				'allowEmpty' => true,
				'types' => $this->allowImageType,
				'wrongType' => 'Only jpg,gif,png are allowed.',
				'maxSize' => $this->maxImageFileSize, // 3MB
				'tooLarge' => 'The file was larger than' . ($this->maxImageFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
			),
//			array(
//				'fileurl', 'match',
//				'pattern' => '/^[^\/?*:&;{}\\]+\.[^\/?*:;{}\\]{3}$/',
//				'message' => 'Image files name cannot be included special characters: &%$#',
//			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, slug, section, fileurl,youtubeurl, status, created_date, posted_by', 'safe', 'on' => 'search'),
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
			'title' => Yii::t('translation', 'Title'),
			'slug' => Yii::t('translation', 'Slug'),
			'section' => Yii::t('translation', 'Section'),
			'fileurl' => Yii::t('translation', 'Image'),
			'youtubeurl' => Yii::t('translation', 'Youtube Url'),
			'status' => Yii::t('translation', 'Status'),
			'created_date' => Yii::t('translation', 'Created Date'),
			'posted_by' => Yii::t('translation', 'Posted By'),
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
		$criteria->compare('title', $this->title, true);
		$criteria->compare('slug', $this->slug, true);
		$criteria->compare('section', $this->section);
		$criteria->compare('fileurl', $this->fileurl, true);
		$criteria->compare('youtubeurl', $this->youtubeurl, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('posted_by', $this->posted_by);
              
		$sort = new CSort();

		$sort->attributes = array(
			'name' => array(
				'asc' => 't.title',
				'desc' => 't.title desc',
				'default' => 'asc',
			),
		);
		$sort->defaultOrder = 't.title asc';


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

	public function behaviors()
	{
		return array('sluggable' => array(
				'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
				'columns' => array('title'),
				'unique' => true,
				'update' => true,
			),);
	}

	public function getDetailBySlug($slug)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.slug', $slug);
		return Gallery::model()->find($criteria);
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
				$this->created_date = date('Y-m-d H:i:s');
			else
				$this->modified_date = date('Y-m-d H:i:s');
			$this->posted_by = Yii::app()->user->id;
		}
		return true;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gallery the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function nextOrderNumber()
	{
		return Gallery::model()->count() + 1;
	}
    public function findGallery(){
        $criteria=new CDbCriteria;
        $criteria->compare('t.section', $this->section);
        $criteria->compare('t.status', STATUS_ACTIVE);

        $sort = new CSort();
        $attSort = array(
            'title' => 'title'
        );

        $sort->attributes = $attSort;
        $sort->defaultOrder = 'title asc';

        return new CActiveDataProvider('Gallery', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=> 12,
            ),
            'sort' => $sort,
        ));

    }
	
	
    public static function getModelBySlug($slug){
        $c = new CDbCriteria();
        $c->compare('t.slug', $slug);
        $c->compare('t.status', STATUS_ACTIVE);
        $model = Gallery::model()->findAll($c);

        if($model)
            return $model[0];
        return '';
    }
}
