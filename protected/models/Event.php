<?php
/**
 * This is the model class for table "{{_event}}".
 *
 * The followings are the available columns in table '{{_event}}':
 * @property string $id
 * @property string $title
 * @property string $image1
 * @property string $image2
 * @property string $title_text
 * @property string $left_text
 * @property string $right_text
 * @property integer $status


 */
class Event extends MyActiveRecord
{
    const IMAGE1_WIDTH_1 = 648;
    const IMAGE1_HEIGHT_1 = 216;
    const IMAGE1_WIDTH_2 = 162;
    const IMAGE1_HEIGHT_2 = 54;

    const IMAGE2_WIDTH_1 = 279;
    const IMAGE2_HEIGHT_1 = 195;
    const IMAGE2_WIDTH_2 = 93;
    const IMAGE2_HEIGHT_2 = 65;
    
    public $aImageSize = array(
        'image1' => array(
                        '648x216' => array('width' => 648, 'height' => 216),
                        '162x54' => array('width' => 162, 'height' => 54),
                    ),
        'image2' => array(
                        '279x195' => array('width' => 279, 'height' => 195),
                        '93x65' => array('width' => 93, 'height' => 65),
                    ),
    );

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return '{{_event}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, title_text, left_text, right_text', 'required'),
            array('image1, image2', 'required', 'on' => 'create'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('title, image1, image2', 'length', 'max'=>255),
            array('image1, image2', 'file',
                'allowEmpty' => true,
                'types' => 'jpg, png, gif',
                'wrongType' => 'Only jpg, png, gif are allowed.',
                'maxSize' => FileHelper::getMaxFileSize(), // 3MB
                'tooLarge' => 'The file was larger than ' . (FileHelper::getMaxFileSize() / 1024) . ' KB. Please upload a smaller file.',
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, image1, image2, title_text, left_text, right_text, status', 'safe', 'on'=>'search'),
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
            'id' => 'ID',
            'title' => 'Title',
            'image1' => 'Banner',
            'image2' => 'Image',
            'title_text' => 'Title Text',
            'left_text' => 'Left Text',
            'right_text' => 'Right Text',
            'status' => 'Status',
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
        $criteria->compare('t.id',$this->id,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.image1',$this->image1,true);
        $criteria->compare('t.image2',$this->image2,true);
        $criteria->compare('t.title_text',$this->title_text,true);
        $criteria->compare('t.left_text',$this->left_text,true);
        $criteria->compare('t.right_text',$this->right_text,true);
        $criteria->compare('t.status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
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

    public function defaultScope()
    {
            return array(
                    //'condition'=>'',
            );
    }
    protected function beforeDelete()
    {
        $image1Path = 'upload/event/'.$this->id;
        $image2Path = 'upload/event/'.$this->id;

        $this->deleteImage('image1', $image1Path, $this->image1);
        $this->deleteImage('image2', $image2Path, $this->image2);

        return parent::beforeDelete();
    }


    //bb - need in each model with the same name: getImageUrl
    public function getImageUrl($fieldName, $width = NULL, $height = NULL)
    {
        if($width && $height)
            $thumbFolder = $width.'x'.$height.'/';
        else
            $thumbFolder = '';
        $path = 'upload/event/'.$this->id.'/'.$thumbFolder.$this->$fieldName;
        return ImageHelper::getImageUrl($path, $width, $height);//get noimage if not availabe
    }
    public function behaviors(){
        return array(
            'sluggable' => array(
                'class'=>'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
                'columns' => array('title'),
                'unique' => true,
                'update' => true,
            ),
        );
    }
}