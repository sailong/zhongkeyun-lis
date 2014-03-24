<?php
/**
 * 质控品
 * @author wyj
 *
 */
//header('content-type:text/html;charset=utf-8');
class QualityControlSampleController extends FrontController
{
	public $pageTitle = '质控品';
	
	private function loadModel($new=false)
	{
		return $new ? new QualityControlSample() : QualityControlSample ::model();
	}
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$data = $userData = array();
		$dataProvider = new CActiveDataProvider('QualityControlSample', array(
				'criteria'=>array(
						'condition' => ' hospital_id = '.Yii::app()->user->hospital_id,
						'order'=>'id DESC',
				),
				'pagination'=>array(
						'pageSize'=>10,
				),
		));
		$data['dataProvider']= $dataProvider;
		$this->render('index',$data);
	}
	
	public function actionModify()
	{
		$id = Yii::app()->request->getParam('id',0);
		if($id)
		{
			$model = $this->loadModel()->findByPk($id);
			if($model) $model->expire_date = date('Y-m-d',$model->expire_date);
		}else
		{
			$model = $this->loadModel(true);
		}
		$data['model'] = $model;
		$this->render('modify',$data);
	}
	
	public function actionModifyDo()
	{
		$post = Yii::app()->request->getParam('QualityControlSample');
		if(!$post) {}
		$id = intval($post['id']);
		if($id) //修改
		{
			$model = $this->loadModel()->findByPk($id);
			if(!$model) {}
			if($model->hospital_id != Yii::app()->user->hospital_id) 
			{
				
			}
			$model->attributes = $post;
			if($model->save())
			{
				echo 'update success';
			}else
			{
				var_dump($model->errors);
			}
		}else //添加
		{
			$model = $this->loadModel(true);
			$model->attributes = $post;
			if($model->insert())
			{
				echo 'insert success';
			}else
			{
				var_dump($model->errors);
			}
		}
	}
	/**
	 * 删除
	 */
	public function actionDelete($id)
	{
		if(!$id) Util::returnAjax(0, '参数错误!');
		$model = $this->loadModel()->findByPk($id);
		if(!$model) Util::returnAjax(0,'该数据不存在或已经被删除！');
		if( $model->hospital_id != Yii::app()->user->hospital_id) Util::returnAjax(0,'无权对此条数据进行删除操作！');
		$model->delete();
		Util::returnAjax(1, '删除成功!');
	}
}