<?php

/**
 * 设备管理
 * @author zhoujianjun
 *
 */

class DeviceController extends FrontController
{
	
   
	/**
	 * 设备列表
	 */
	public function actionIndex()
	{
		$model = new Device();
   		$model->unsetAttributes();
   		if(isset($_GET['Device']))
   			$model->attributes=$_GET['Device'];
   		$this->render('index',array('model'=>$model));
	}
	
	/**
	 * 添加设备
	 */
	public function actionCreate()
	{
		$model = new Device();
		if(isset($_POST['Device']))
		{
			$param = $_POST['Device'];
			$param['production_date'] = strtotime($param['production_date']);
			$param['release_date'] = strtotime($param['release_date']);
			$model->attributes = $param;
			if($model->save())
    		{
    			Yii::app()->user->setFlash('device','创建成功');
    			$this->redirect('index');
    		}else{
    			print_r($model->getErrors());
    		}
		}
		$categorys = Category::model()->findAll();
		$this->registerValidateScript();
		$this->render('create',array('categorys'=>$categorys));
	}
	
	/**
	 * 
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->status = Device::STATUS_DELETE;
		$model->update(array('status'));
		echo CJSON::encode(array('status'=>1,'msg'=>'删除成功'));
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Device::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}