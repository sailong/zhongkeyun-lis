<?php

/**
 * 自定义项目参数
 * @author zhoujianjun
 *
 */
class ParameterController extends FrontController
{
	
	
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$model = new CustomTestItem();
		$model->unsetAttributes();
		if(isset($_GET['CustomTestItem']))
			$model->attributes=$_GET['CustomTestItem'];
		$this->render('index',array('model'=>$model));
		
		
	}
	
	/**
	 * 添加
	 */
	public function actionCreate()
	{
		$model = new CustomTestItem();
		if(isset($_POST['CustomTestItem']))
		{
			$model = new CustomTestItem();
			$model->attributes = $_POST['CustomTestItem'];
			if($model->save())
			{
				Yii::app()->user->setFlash('CustomTestItem','添加成功');
				$this->redirect('index');
			}else{
				$error = array_values($model->getErrors());
				Yii::app()->user->setFlash('CustomTestItem', $error[0][0]);
			}
		}
		$categorys = Category::model()->findAll();
		$this->registerValidateScript();
		$this->render('create',array('categorys'=>$categorys,'model'=>$model));
	}
	
	/**
	 * 编辑
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if(isset($_POST['CustomTestItem']))
		{
			$model->attributes = $_POST['CustomTestItem'];
			if($model->save())
			{
				Yii::app()->user->setFlash('CustomTestItem','编辑成功');
				$this->redirect('/parameter/index');
			}else{
				$error = array_values($model->getErrors());
				Yii::app()->user->setFlash('CustomTestItem', $error[0][0]);
			}
		}
		$categorys = Category::model()->findAll();
		$this->registerValidateScript();
		$this->render('update',array('categorys'=>$categorys, 'model'=>$model));
	}
	
	/**
	 * 删除
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->status = CustomTestItem::STATUS_DELETE;
		$model->update(array('status'));
		echo CJSON::encode(array('status'=>1,'msg'=>'删除成功'));
	}
	
	
	/**
	 * 根据分类id获取对应的设备
	 */
	public function actionGetDevice()
	{
		$category_id = Yii::app()->request->getParam('category_id',1);
		$devices = Device::model()->findAllByAttributes(array('category_id'=>$category_id));
		$html = $this->renderPartial('_device',array('devices'=>$devices),true);
		echo CJSON::encode(array('status'=>1,'msg'=>$html));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CustomTestItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}