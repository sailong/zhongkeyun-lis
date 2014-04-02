<?php
/**
 * 质控通道
 * @author wyj
 *
 */
class QualityControlChannelController extends FrontController
{
	public $pageTitle = '质控通道';
	
	private function loadModel($new=false)
	{
		return $new ? new QualityControlChannel() : QualityControlChannel ::model();
	}
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$data['channelData'] = array();
		$deviceId = Yii::app()->request->getParam('deviceId',0);
		$deviceId = intval($deviceId);
		if($deviceId)
		{
			$channelData = $this->loadModel()->findAll(' device_id = '.$deviceId);
			if($channelData)
			{
				foreach ($channelData as $channel)
				{
					$data['channelData'][$channel->sample_category_id]['channel'] = $channel->channel;
				}
			}
		}
		$condition = ' hospital_id = '.Yii::app()->user->hospital_id;
		//设备数据
		$data['deviceData'] = Device::model()->findAll($condition);
		//质控品数据
		$data['sampleData'] = QualityControlSampleCategory::model()->findAll($condition);
		//把已经设置好的 放到前面显示
		if($data['channelData'] && $data['sampleData'])
		{
			$tempData = array();
			foreach ($data['sampleData'] as $key=>$sample)
			{
				if(isset($data['channelData'][$sample->id]))
				{
					unset($data['sampleData'][$key]);
					$tempData[] = $sample;
				}
			}
			$data['sampleData'] = array_merge($tempData,$data['sampleData']);
		}
		$data['deviceId'] = $deviceId;
		$this->render('index',$data);
	}
	
	/**
	 * 保存通道设置
	 */
	public function actionSaveData()
	{
		$deviceId = Yii::app()->request->getParam('deviceId');
		$channel = Yii::app()->request->getParam('channel');
		if(!$deviceId || !$channel ) {}
		$device = Device::model()->findByPk($deviceId);
		if(!$device || $device->hospital_id !=  Yii::app()->user->hospital_id) { }
	
		foreach ($channel as $sampleId => $ch)
		{
			$ch = trim($ch);
			$attributes = array('device_id'=>$deviceId,'sample_category_id'=>$sampleId);
			if(!$ch)
			{
				$this->loadModel()->deleteAllByAttributes($attributes);
			}else
			{
				//判断是否设置过
				$model = $this->loadModel()->findByAttributes($attributes);
				if($model)
				{
					//修改
					if($model->channel != $ch)
					{
						$model->channel   = $ch;
						$model->update_time = time();
						$model->save();
					}
				}else 
				{
					$model = $this->loadModel(true);
					$model->device_id = $deviceId;
					$model->sample_category_id = $sampleId;
					$model->channel   = $ch;
					$model->add_time = time();
					$model->insert();
					$model->id = 0;
					$model->setIsNewRecord(true);
				}
			}
		}
		Yii::app()->user->setFlash('QualityControlChannel','设置成功');
		$this->redirect(array('index','deviceId'=>$deviceId));
		//先清空原来数据
		/* $this->loadModel()->deleteAllByAttributes(array('device_id'=>$deviceId));
		//保存新数据
		$model = $this->loadModel(true);
		foreach ($channel as $sampleId => $ch)
		{
			$ch = trim($ch);
			if($ch)
			{
				$model->device_id = $deviceId;
				$model->sample_category_id = $sampleId;
				$model->channel   = $ch;
				$model->add_time = time();
				$model->insert();
				$model->id = 0;
				$model->setIsNewRecord(true);
			}
		} */
	}

}