<?php

/**
 * 自定义报告单
 * @author zhoujianjun
 *
 */
class CustomResultController extends FrontController
{
	
	/**
	 * 添加自定义报告单
	 */
	public function actionCreate($id)
	{
		$record = $this->loadModel($id);
		if(isset($_POST['Custom']))
		{
			$data = array_combine($_POST['Custom']['itemName'], $_POST['Custom']['itemValue']);
			$category_id = Yii::app()->request->getParam('category_id');
			if(!empty($data))
			{
				$values = array();
				$patient_id = $record->patient_id;
				$i=1;
				$sql = "INSERT into custom_test_result(record_id,patient_id,category_id,parameter_id,value,create_time) values ";
				$placesholder = array();
				$insertValues = array();
				foreach ($data as $key => $value)
				{
					$fields = array(':record_id'.$i, ':patient_id'.$i, ':category_id'.$i, ':parameter_id'.$i, ':value'.$i, ':create_time'.$i);
					$placesHolders[] = '(' . join(',', $fields) . ')';
					$values = array($id, $patient_id, $category_id, $key, $value, time());
					$insertValues += array_combine($fields, $values);
					$i++;
				}
				$sql .= join(',', $placesHolders);
				$command = Yii::app()->db->createCommand($sql);
				$command->bindValues($insertValues);
				$command->execute();
				Yii::app()->user->setFlash('customResult','添加成功');
				$this->redirect('/record/index');
			}
		}
		$categorys = Category::model()->custom()->findAll();
		$this->registerValidateScript();
		$this->render('create', array('categorys'=>$categorys,'model'=>$record));
		
	}
	
	/**
	 * 根据分类获取其下自定义参数
	 */
	public function actionGetItems()
	{
		$category_id = intval(Yii::app()->request->getParam('category_id',1));
		$category = Category::model()->findByPk($category_id);
		if(empty($category) || $category->automatic == Category::AUTOMATIC_YES)
		{
			echo CJSON::encode(array('status'=>0,'msg'=>'参数错误'));
			Yii::app()->end();
		}
		$items = CustomTestItem::model()->findAllByAttributes(array('category_id'=>$category_id));
		$data = array();
		if(!empty($items))
		{
			foreach ($items as $item)
			{
				$data[] = array('name'=>$item->name, 'value'=>$item->id);
			}
		}
		echo CJSON::encode(array('status'=>1,'msg'=>'成功','data'=>$data));
		Yii::app()->end();
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