<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class OnlinetimeslotController extends Controller {

	public $layout = '/layouts/column';
	public $breadcrumbs = array();
	public $menu = array();
    public $title;
    public $client;

	function init () {
		parent::init();
        $this->registerClientScripts();
	}

   	public function getAssets($path = '', $hashByName = false, $level = -1)
    {
        $class_name = get_class($this);
        $class = new ReflectionClass($class_name);
        $path = dirname(dirname($class->getFileName())) . '/assets/' . $path;
        $force_copy = YII_DEBUG;

        return Yii::app()->getAssetManager()->publish($path, $hashByName, $level, $force_copy);
    }

    public function registerClientScripts(){
        $clientScript = Yii::app()->clientScript;
        $assets = $this->getAssets();
        $base_url = Yii::app()->theme->baseUrl;

        $clientScript->registerScriptFile($base_url . '/js/angular.min.js', CClientScript::POS_HEAD);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.general.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.module.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.service.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.bufferController.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.buffer-time.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.buffer.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.address.js", CClientScript::POS_END);
        $clientScript->registerScriptFile("{$assets}/scripts/timeslot.statictime.js", CClientScript::POS_END);
        $clientScript->registerCssFile("{$assets}/css/timeslot.template.css");
    }

}