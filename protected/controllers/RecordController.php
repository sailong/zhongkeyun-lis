<?php

/**
 * 报告单管理
 * @author zhoujianjun
 *
 */
class RecordController extends FrontController
{
	
	
	/**
	 * 
	 * @see CController::behaviors()
	 */
	public function behaviors()
	{
		return array(
			'print' => 'application.components.behaviors.PrintBehavior'
		);
	}
	
	/**
	 * 报告列表
	 */
	public function actionIndex()
	{
		$model = new PatientTestRecord();
		$model->unsetAttributes();
		if(isset($_GET['Record']))
			$model->attributes=$_GET['Record'];
		$this->render('index',array('model'=>$model));
	}
	
	/**
	 * 报告单检测
	 */
	public function actionCreate()
	{
		if(isset($_POST['Record']))
		{
			$param = $_POST['Record'];
			$param['sample_time'] = strtotime($param['sample_time']);
			$param['test_time'] = strtotime($param['test_time']);
			$param['reporting_time'] = strtotime($param['reporting_time']);
			$record = new PatientTestRecord();
			$record->attributes = $param;
			if($record->save())
			{
				if(Yii::app()->request->getIsAjaxRequest())
				{
					// 检测
				}else{
					// 自定义报告单
					$url = $this->createUrl('/customResult/create',array('id'=>$record->id));
					$this->redirect($url);
				}
			}else{
				$error = array_values($record->getErrors());
				if(Yii::app()->request->getIsAjaxRequest())
				{
					echo CJSON::encode(array('staus'=>0,'msg'=>$error[0][0]));
					Yii::app()->end();
				}else{
					Yii::app()->user->setFlash('Record');
				}
			}
		}
		$operators = User::model()->findAll();
		$doctores = Doctor::model()->findAll();
		$devices = Device::model()->findAll();
		$categorys = Category::model()->findAll();
		$departments = Departments::model()->findAll();
		$this->render('create',array('operators'=>$operators,'doctores'=>$doctores,'devices'=>$devices,'categorys'=>$categorys,'departments'=>$departments));
	}
	
	
	/**
	 * 报告单详情
	 * @param unknown $id
	 */
	public function actionView($id)
	{
		$model = PatientTestRecord::model()->with('patient','department', 'category')->findByPk($id);
		if(!empty($model))
			$this->render('view',array('model'=>$model));
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}
	
	/**
	 * 检测结果(table 列表显示)
	 * @param $id int record id,即检测id
	 */
	public function actionResult($id)
	{
		$model = PatientTestRecord::model()->with('category')->findByPk($id);
		if(!empty($model))
		{
			$model->category->automatic == Category::AUTOMATIC_YES ? $this->showDeviceResult($model) : $this->showCustomResult($model);
		}
		else 
			throw new CHttpException(404,'The requested page does not exist.');
	}
	
	
	/**
	 * 非机器检测的结果
	 */
	private function showCustomResult(&$model)
	{
		$dataProvider = new CActiveDataProvider('CustomTestResult',array(
			'criteria' => array(
				'condition' => "record_id={$model->id}",
				'with' => 'parameter'
			),
		));
		$this->render('result_custom',array('dataProvider'=>$dataProvider,'model'=>$model));
	}
	
	/**
	 * 显示机器检测的结果
	 */
	private function showDeviceResult(&$model)
	{
		$dataProvider = new CActiveDataProvider('PatientTestResult',array(
			'criteria' => array(
				'condition' => "record_id={$model->id}",
				'with' => 'parameter'
			),
		));
		$this->render('result_device',array('dataProvider'=>$dataProvider,'model'=>$model));
	}
	
	/**
	 * 打印(用户不一定真的打印)
	 * @param $id int record id
	 */
	public function actionPrint($id)
	{
		$this->layout = 'main';
		$model = PatientTestRecord::model()->with('patient','department', 'category')->findByPk($id);
		$position = intval(Yii::app()->request->getParam('position',0));
		if($model->category->automatic == Category::AUTOMATIC_YES)
		{
			$result = PatientTestResult::model()->with('parameter')->findAll(array('condition' => "record_id={$model->id}"));
		}else{
			$result = CustomTestResult::model()->with('parameter')->findAll(array('condition' => "record_id={$model->id}"));
		}
		$this->render('print',array('model'=>$model,'position'=>$position,'result'=>$result));
	}
	
	/**
	 * 打印之前调用,记录打印开始
	 */
	public function actionBeforePrint($id)
	{
		if(Yii::app()->request->getIsAjaxRequest())
		{
			$model = $this->loadModel($id);
			$position = intval(Yii::app()->request->getParam('position',0));
			$this->onBeforePrint(new CEvent($this,array('model'=>$model,'position'=>$position)));
		}
	}
	
	public function onBeforePrint($event)
	{
		$this->raiseEvent('onBeforePrint', $event);
	}
	
	/**
	 * 打印之后调用,记录是否打印完成
	 */
	public function actionAfterPrint($id)
	{
		if(Yii::app()->request->getIsAjaxRequest())
		{
			$model = $this->loadModel($id);
			$position = intval(Yii::app()->request->getParam('position',0));
			$this->onAfterPrint(new CEvent($this,array('model'=>$model,'position'=>$position)));
		}
	}
	
	public function onAfterPrint($event)
	{
		$this->raiseEvent('onAfterPrint', $event);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=PatientTestRecord::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}