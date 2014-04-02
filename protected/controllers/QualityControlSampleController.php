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
	public $modelName = 'QualityControlSample';
	
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
		$condition = ' hospital_id = '.Yii::app()->user->hospital_id;
		$model = $this->loadModel();
		if(isset($_GET['QualityControlSample']))
		{
			$model->attributes = $_GET['QualityControlSample'];
			if($model->category_id) $condition.= " AND category_id = ".$model->category_id;
		}
		$dataProvider = new CActiveDataProvider('QualityControlSample', array(
				'criteria'=>array(
						'condition' => $condition,
						'order'=>'id DESC',
				),
				'pagination'=>array(
						'pageSize'=>10,
				),
		));
		$data['dataProvider']= $dataProvider;
		$data['model'] = $model;
		$data['sampleCategory'] = QualityControlSampleCategory::model()->getSampleCategoryNameListArray();
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
		$data['sampleCategory'] = QualityControlSampleCategory::model()->getSampleCategoryNameListArray();
		$this->render('modify',$data);
	}
	
	public function actionModifyDo()
	{
		$post = Yii::app()->request->getParam($this->modelName);
		$id = intval($post['id']);
		$model = $this->loadModel();
		if($model->checkUnique($post['category_id'], $post['number'], $post['producer'],$id))
		{
			$model->attributes = $post;
			$data['model'] = $model;
			$data['sampleCategory'] = QualityControlSampleCategory::model()->getSampleCategoryNameListArray();
			Yii::app()->user->setFlash($this->modelName,'操作失败：该生产厂家的该批号质控品已经存在，请重新编辑输入！');
			$this->render('modify',$data);
			die;
		}
		if($id) //修改
		{
			$model = $model->findByPk($id);
			if(!$model) {}
			if($model->hospital_id != Yii::app()->user->hospital_id) 
			{
				Yii::app()->user->setFlash($this->modelName,'操作失败：没有权限进行此操作！');
				$this->redirect(array('modify','id'=>$id));
			}
			$model->attributes = $post;
			if($model->save()!=false)
			{
				Yii::app()->user->setFlash($this->modelName,'修改成功！');
			}else
			{
				var_dump($model->errors);
				die;
				Yii::app()->user->setFlash($this->modelName,'操作失败');
				$this->redirect(array('modify','id'=>$id));
			}
		}else //添加
		{
			$model = $this->loadModel(true);
			$model->attributes = $post;
			if($model->insert())
			{
				Yii::app()->user->setFlash($this->modelName,'添加成功！');
			}else
			{
				var_dump($model->errors);
				die;
			}
		}
		$this->redirect(array('index'));
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
		Util::returnAjax(1);
	}
}