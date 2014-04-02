<?php
/**
 * 质控项目
 * @author wyj
 *
 */
class QualityControlLogController extends FrontController
{
	public $pageTitle = '质控项目';
	
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$deviceId = Yii::app()->request->getParam('deviceId',0);
		$date = Yii::app()->request->getParam('date',0);
		$sampleCategoryId = Yii::app()->request->getParam('sampleCategoryId',0);
		$sampleNumber = Yii::app()->request->getParam('sampleNumber',0);
		if($deviceId)
		{
			$criteria = new CDbCriteria();
			$criteria->order  = 'id desc';
			$criteria->addCondition('device_id = '.$deviceId);
			
			//获取设备项目参数
			$device = Device::model()->findByPk($deviceId);
			if($device && $device->category_id )
			{
				$data['item'] = CustomTestItem::model()->findAllByAttributes(array('category_id' => $device->category_id));
			}
			//获取对应通道信息
			if($sampleCategoryId)
			{
				//获取通道id
				$channel = QualityControlChannel::model()->findByAttributes(array('device_id' => $deviceId, 'sample_category_id' => $sampleCategoryId));
				if($channel)
				{
					$channelId = $channel->id;
					$criteria->addCondition('channel_id = '.$channelId);	
				}	
			}
			if($date)
			{
				$dateArr = explode('-',$date);
				$startTime = strtotime($date);
				$endTime = mktime(0,0,0,$dateArr[1]+1,1,$dateArr[0]) - 1;
				$criteria->addCondition("create_time >= $startTime AND create_time < $endTime");
			}
			//质控品批号
			if($sampleNumber)
			{
				
			}
		}
		$condition = ' hospital_id = '.Yii::app()->user->hospital_id;
		$data['deviceData'] = Device::model()->findAll($condition);
		$data['sampleCategory'] = QualityControlSampleCategory::model()->findAll();
		$this->render('index',$data);
	}
	/**
	 * 获取质控品批号
	 * @param int $sampleCategoryId
	 */
	public function actionGetSampleNumber($sampleCategoryId)
	{
		if(!$sampleCategoryId) return;
		$number = QualityControlSample::model()->findAllByAttributes(array('category_id' => $sampleCategoryId));
		$options = '<option value="">请选择</option>';
		foreach ($number as $n)
		{
			$options.='<option value="'.$n->number.'">'.$n->number.'</option>';
		}
		Util::returnAjax(1,'',$options);
	}
	
	public function actionT()
	{
		return;
		$model = new QualityControlResult();
		$time = strtotime('2014-03-01');
		$data['record_id'] = $data['device_id'] = 1;
		$data['code'] = 'PRC';
		for ($i=0;$i<=30;$i++)
		{
			$data['value'] = mt_rand(1,20);
			$data['create_time'] = $time + $i * 3600 * 24 + mt_rand(1, 3600 * 24);
			$model->attributes = $data;
			$model->insert();
			$model->id = 0;
			$model->setIsNewRecord(true);
		}
		
		echo 'okokokoko';
	}
	

}