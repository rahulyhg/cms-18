<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AppointmentController extends FrontController {

	public $layout = '//layouts/site';
	public $breadcrumbs = array();
	public $menu = array();
    public $title;
    public $client;

	function init () {
		parent::init();
	}

	public function getAssets($path = '', $hashByName = false, $level = -1)
    {
        $class_name = get_class($this);
        $class = new ReflectionClass($class_name);
        $path = dirname(dirname($class->getFileName())) . '/assets/' . $path;
        $force_copy = YII_DEBUG;

        return Yii::app()->getAssetManager()->publish($path, $hashByName, $level, $force_copy);
    }

}