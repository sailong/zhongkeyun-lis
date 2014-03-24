<?php
/**
 * 紫外线消毒
 * @author wyj
 *
 */
class DisinfectController extends FrontController
{
	
	private function loadModel($new=false)
	{
		return $new ? new DisinfectLog() : DisinfectLog::model();
	}
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$data = $userData = array();
		$dataProvider = new CActiveDataProvider('DisinfectLog', array(
				'criteria'=>array(
						'condition' => ' hospital_id = '.Yii::app()->user->hospital_id,
						'order'=>'id DESC',
				),
				'pagination'=>array(
						'pageSize'=>1,
				),
		));
		//获取用户名
		$logData = $dataProvider->getData();
		if($logData)
		{
			$uidArr = array();
			foreach ($logData as $log)
			{
				$uidArr[] = $log['operator_id'];
			}
			$userData = User::model()->getUserDataBatch($uidArr,array('name'));
		}
		$data['userData'] = $userData;
		//判断是否签到过
		$todayUnixTime = strtotime(date('Y-m-d'));
		$model = $this->loadModel();
		$data['sign'][1] = $model->checkHasSign(Yii::app()->user->id, $todayUnixTime, 1);
		$data['sign'][2] = $model->checkHasSign(Yii::app()->user->id, $todayUnixTime, 2);
		$data['dataProvider']= $dataProvider;
		$this->render('index',$data);
	}
	
	
	public function getTimeStrById($id)
	{
		$arr = DisinfectLog::$dayTimeArr;
		return isset($arr[$id]) ? $arr[$id]:'';
	}
	/**
	 * 签到
	 */
	public function actionSign()
	{
		$timeId = Yii::app()->request->getParam('time_id',0);
		$hour = Yii::app()->request->getParam('hour',0);
		if(!$timeId || !$hour) Util::returnAjax(0,'参数错误');
		
		$todayUnixTime = strtotime(date('Y-m-d'));
		$model = $this->loadModel();
		$data = $model->checkHasSign(Yii::app()->user->id, $todayUnixTime, $timeId);
		if($data) Util::returnAjax(0,'今天您已经签过到了！');
		
		$value['time_id'] = $timeId;
		$value['hospital_id'] = Yii::app()->user->hospital_id;
		//获取最近一次 上/下午的签到记录
		$param['order'] = 'id desc';
		$param['condition'] = " time_id = $timeId and hospital_id = ".$value['hospital_id'];
		$param['limit'] = 1;
		$data = $model->findAll($param);
		$data = array_pop($data);
		$value['disinfect_hours'] = $data ? $hour + $data->disinfect_hours : $hour;
		$value['operator_id'] = Yii::app()->user->id;
		$value['disinfect_day'] = $todayUnixTime;
		$value['create_time'] = time();
		$model = $this->loadModel(true);
		$model->attributes = $value;
		if($model->save()) Util::returnAjax(1);
		Util::returnAjax(0,'签到失败');
	}
}