<?php

/**
 * 用户检测记录相关的行为
 * @author zhoujianjun
 *
 */
class PrintBehavior extends CBehavior
{
	
	public function events()
	{
		return array(
			'onBeforePrint' => 'beforePrint',
			'onAfterPrint'  => 'afterPrint',
		);
	}
	
	/**
	 * 打印之前记录print_log日志
	 * @param unknown $event
	 */
	public function beforePrint($event)
	{
		$model = $event->params['model'];
		$position = isset($event->params['position']) ? $event->params['position'] : 0;
		if($model instanceof PatientTestRecord)
			$type = RecordPrintLog::TYPE_PATIENT_TEST_RECORD;
		elseif($model instanceof QualityControlRecord)
			$type = RecordPrintLog::TYPE_CONTROL_TEST_RECORD;
		else 
			$type = 0;
		$printLog = new RecordPrintLog();
		$printLog->attributes = array(
			'record_id' => $model->id,
			'type' => $type,
			'operator_id' => Yii::app()->user->id,
			'status' => RecordPrintLog::PRINT_STATUS_BEGIN,
			'position' => $position,
			'create_time' => time()
		);
		$printLog->save();
		Yii::app()->user->setFlash('printLogId', $printLog->id);
	}
	
	/**
	 * 打印完后,更改记录已打印标识,同时更改打印日志为打印完成状态
	 * @param unknown $event
	 */
	public function afterPrint($event)
	{
		// 更改检测记录里打印状态信息
		$model = $event->params['model'];
		$model->updateByPk($model->id, array('print'=>PatientTestRecord::PRINT_YES, 'print_time'=>time()));
		
		// 更改打印日志里,打印已完成信息
		if(Yii::app()->user->hasFlash('printLogId'))
		{
			$printLogId = Yii::app()->user->getFlash('printLogId');
			$logModel = RecordPrintLog::model()->findByPk($printLogId);
			if(!empty($logModel) && $logModel->record_id == $model->id)
			{
				$logModel->updateByPk($printLogId, array('status'=>RecordPrintLog::PRINT_STATUS_OVER,'print_time'=>time()));
			}
		}
	}
	
}