<?php

class CategoryController extends FrontController
{
    
	/**
	 * 分类列表
	 */
   public function actionIndex()
   {
   		$model = new Category();
   		$model->unsetAttributes();
   		if(isset($_GET['Category']))
   			$model->attributes=$_GET['Category'];
   		$this->render('index',array('model'=>$model));
   }  
    
    /**
     * 添加项目分类
     */
    public function actionCreate()
    {
    	if(isset($_POST['Category']))
    	{
    		$model = new Category();
    		$model->attributes = $_POST['Category'];
    		if($model->save())
    		{
    			Yii::app()->user->setFlash('category','添加成功');
    			$this->redirect('index');
    		}else{
    			$error = array_values($model->getErrors());
				Yii::app()->user->setFlash('category', $error[0][0]);
    		}
    	}
    	
    	$this->registerValidateScript();
    	$this->render('create');
    }
    
    /**
     * 删除某一个项目分类
     */
    public function actionDelete($id)
    {
    	$model = $this->loadModel($id);
    	$model->status = Category::STATUS_DELETE;
    	$model->update(array('status'));
    	// 删除分类下的自定义参数
    	CustomTestItem::model()->updateAll(array('status'=>CustomTestItem::STATUS_DELETE),array('condition'=>"category_id=$model->id"));
    	echo CJSON::encode(array('status'=>1,'msg'=>'删除成功'));
    }
    
    /**
     * 更新
     */
    public function actionUpdate($id)
    {
    	
    	
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
    	$model=Category::model()->findByPk($id);
    	if($model===null)
    		throw new CHttpException(404,'The requested page does not exist.');
    	return $model;
    }
    
}