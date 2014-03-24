<?php

class RecordController extends FrontController
{
	
	public $defaultAction = 'check';
	
	
	/**
	 * 报告单检测
	 */
	public function actionCheck()
	{
		
		//echo Yii::app()->user->hospital_id;die;
		$this->render('check');
	}
	
	
	
	
}