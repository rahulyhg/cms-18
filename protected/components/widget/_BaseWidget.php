<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class _BaseWidget extends CWidget
{

	public $singleTitle = 'Trades and sales';

	/*
	 * Austin added date 9/7/2014
	 * Show nofify message if it has
	 */

	public function renderNotifyMessage()
	{
		if (Yii::app()->user->hasFlash('beFormAction'))
		{
			echo '<div class="alert alert-success" role="alert">'
			. Yii::app()->user->getFlash('beFormAction') .
			'</div>';
		}

		if (Yii::app()->user->hasFlash('beFormError'))
		{
			echo '<div class="alert alert-danger" role="alert">'
			. Yii::app()->user->getFlash('beFormError') .
			'</div>';
		}
	}

	public function getCurrentUrlWithoutParam()
	{
		$uriWithoutParam = $_SERVER['REQUEST_URI'];
		if (strpos($uriWithoutParam, '?') != false)
			$uriWithoutParam = substr($uriWithoutParam, 0, strpos($uriWithoutParam, '?'));
		return 'http://' . $_SERVER['SERVER_NAME'] . $uriWithoutParam;
	}

}
?>

