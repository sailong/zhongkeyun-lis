<?php

/**
 * 人员管理
 * @author zhoujianjun
 * @tip 表user增加了status字段
 */
class OperatorController extends FrontController
{
	
	
	
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$model = new User();
		$model->unsetAttributes();
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
		$this->render('index',array('model'=>$model));
	}
	
	/**
	 * 添加
	 */
	public function actionCreate()
	{
		if(isset($_POST['User']))
		{
			$param = $_POST['User'];
			$model = new User();
			$model->attributes = $param;
			if($model->save())
			{
				Yii::app()->authManager->assign($param['role'],$model->id);
				Yii::app()->user->setFlash('User','创建成功');
				$this->redirect('index');
			}else{
				$error = array_values($model->getErrors());
				Yii::app()->user->setFlash('User', $error[0][0]);
			}
		}
		$roles = Authitem::model()->roles()->findAll();
		$departments = Departments::model()->findAll();
		$this->render('create',array('roles'=>$roles,'departments'=>$departments));
	}
	
	/**
	 * 删除
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->status = User::STATUS_DELETE;
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
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}