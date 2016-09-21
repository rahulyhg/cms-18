<?php
class News extends _BasePost 
{
	public $uploadImageFolder = 'upload/cms'; //remember remove ending slash
	public $defineImageSize = array(
								'featured_image' => array(array('alias' => 'thumb1', 'size' => '204x94')), 
								);	
	public $pageType = 'news';
	public $categoryId;
	
	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	public function defaultScope()
    {
        return array(
            'condition'=>"post_type='" . $this->pageType . "'",
        );
    }
	
	public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
		$return =  array(
            'postsCategories' => array(self::HAS_MANY, 'PostsCategories', 'post_id', 'joinType' => 'INNER JOIN'),
			'category' => array(self::HAS_MANY, 'NewsCategory', array('category_id' => 'id'), 'through' => 'PostsCategories', 'joinType' => 'INNER JOIN'),
			'categoryLink' => array(self::MANY_MANY, 'NewsCategory', $this->tablePrefix() . '_posts_categories(post_id, category_id)', 'together' => true, 'joinType' => 'LEFT JOIN'),
        );
        return $return;
    }
	
	public function getSlugById($id)
	{
		return News::model()->findByPk((int)$id);
	}
	
	
	
	public function nextOrderNumber()
	{
		return News::model()->count() + 1;
	}
}

