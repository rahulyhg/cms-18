<?php

/**
 * This is the model class for table "{{_banners}}".
 *
 * The followings are the available columns in table '{{_banners}}':
 * @property integer $id
 * @property string $banner_title
 * @property string $banner_decsription
 * @property string $thumb_image
 * @property string $large_image
 * @property string $link
 * @property integer $place_holder_id
 *  doctor_name, doctor_description, 
 */
class Banners extends _BaseModel
{
    public $image;
    public $imageFile;
    public static $folderUpload = 'banner';
    public $maxOrderBanner;
    public $minOrderBanner;
    public $maxOrderLogo;
    public $minOrderLogo;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banners the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_banners}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
            array('imageFile', 'required', 'on'=>'create'),
			array('place_holder_id, order_display, status', 'numerical', 'integerOnly'=>true),
			array('link', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, id, banner_title,banner_description, large_image, link, place_holder_id,imageFile, order_display, status, created_date', 'safe'),
            array('imageFile', 'file',
                'allowEmpty'=>true,
                'types'=> 'jpg,gif,png,jpeg',
                'wrongType'=>'Only jpg,gif,png,jpeg are allowed.',
                'maxSize' => FileHelper::getMaxFileSize(), // 3MB
                'tooLarge' => 'The file was larger than '.(FileHelper::getMaxFileSize()/1024).' KB. Please upload a smaller file.',
            ),
            array(
                'imageFile','match',
                'pattern'=>'/^[^\\/?*:&;{}\\\\]+\\.[^\\/?*:;{}\\\\]{3,4}$/',
                'message'=>'Image files name cannot include special characters: &%$#',
            ),
                    
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
            'placeholder' => array(self::BELONGS_TO, 'PlaceHolders', 'place_holder_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'banner_title' => 'Title',
			'banner_description' => 'Description',
			'thumb_image' => 'Thumb Image',
			'large_image' => 'Image',
            'imageFile' => 'Image',
			'link' => 'Link',
			'place_holder_id' => 'Place Holder',
            'order_display' => 'Display Order'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $criteria->compare('name',trim($this->name),true);
		$criteria->compare('banner_title',$this->banner_title,true);
		$criteria->compare('banner_description',$this->banner_description,true);
		$criteria->compare('thumb_image',$this->thumb_image,true);
		$criteria->compare('large_image',$this->large_image,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('place_holder_id',$this->place_holder_id);

        $criteria->order = 'place_holder_id, order_display';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array('pageSize' => 50)
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

    public static function maxOrderBanner(){
        $maxOrder = Yii::app()->db->createCommand()
            ->select('MAX(order_display) as maxOrder')
            ->from(Banners::model()->tableName())
            ->queryScalar();
        return $maxOrder;
    }

    public static function minOrderBanner(){
        $minOrder = Yii::app()->db->createCommand()
            ->select('MIN(order_display) as minOrder')
            ->from(Banners::model()->tableName())
            ->queryScalar();
        return $minOrder;
    }

    public static function findActiveBanner(){
        $model = self::model()->findAll(array('condition'=>'status = 1','order'=>'order_display'));
        return $model;
    }

}