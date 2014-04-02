<?php

/**
 * 权限管理
 * @author zhoujianjun
 *
 */
class AccessController extends FrontController
{
	
	
	
	/**
	 * 权限列表
	 */
	public function actionIndex()
	{
		$model = new Authitem();
   		$model->unsetAttributes();
   		if(isset($_GET['AuthItem']))
   			$model->attributes=$_GET['AuthItem'];
   		$this->render('index',array('model'=>$model));
	}
	
	/**
	 * 增加角色
	 */
	public function actionCreate()
	{
		$authItem = new Authitem();
		if(isset($_POST['AuthItem']))
		{
			$param = $_POST['AuthItem'];
			$authItem->attributes = $param;
			if($authItem->validate())
			{
				if($authItem->createRoles($param))
				{
					Yii::app()->user->setFlash('AuthItem', '创建成功');
					$this->redirect('index');
				}
				else
					Yii::app()->user->setFlash('AuthItem', '创建失败');
			}else{
				$error = array_values($authItem->getErrors());
				Yii::app()->user->setFlash('AuthItem', $error[0][0]);
			}
		}
		$items = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_TASK);
		$this->registerValidateScript();
		$this->render('create',array('items'=>$items, 'model'=>$authItem));
	}
	
	/**
	 * 删除角色
	 * @param unknown $id
	 */
	public function actionDelete($id)
	{
		Yii::app()->authManager->removeAuthItem($id);
		echo CJSON::encode(array('status'=>1,'msg'=>'删除成功'));
	}
	
	/**
	 * 更新权限
	 */
	public function actionUpdate($id)
	{
		$model = Authitem::model()->roles()->findByPk($id);
		if(empty($model))
			throw new CHttpException(404,'The requested page does not exist.');
		if(isset($_POST['AuthItem']))
		{
			$oldItem = $model->name;
			$param = $_POST['AuthItem'];
			$model->attributes = $param;
			if($model->validate())
			{
				$authItem = new CAuthItem(null, $param['name'] . '-' . Yii::app()->user->hospital_id, $model->type, $param['description']);
				Yii::app()->authManager->saveAuthItem($authItem, $oldItem);
				Yii::app()->user->setFlash('AuthItem', '编辑成功');
				$this->redirect('/access/index');
			}else{
				$error = array_values($model->getErrors());
				Yii::app()->user->setFlash('AuthItem', $error[0][0]);
			}
		}
		$items = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_TASK);
		$auths = Yii::app()->authManager->getItemChildren($model->name);
		$authItem = array();
		if(!empty($auths))
		{
			foreach ($auths as $key => $value)
			{
				array_push($authItem, $value->name);
			}
		}
		$this->registerValidateScript();
		$this->render('update', array('model'=>$model,'items'=>$items, 'authItem' => $authItem));
	}
	
	
	/**
	 * 初始化权限
	 */
	public function actionOne()
	{
		$auth=Yii::app()->authManager;
		
		// 权限管理
		$auth->createOperation('operator/index','查看用户');
		$auth->createOperation('operator/add','添加用户');
		$auth->createOperation('operator/delete','删除用户');
		$auth->createOperation('access/index','查看角色');
		$auth->createOperation('access/add','添加角色');
		$task = $auth->createTask('accessControl', '权限管理');
		$task->addChild('operator/index');
		$task->addChild('operator/add');
		$task->addChild('operator/delete');
		$task->addChild('access/index');
		$task->addChild('access/add');
		
		// 项目分类
		$auth->createOperation('category/index', '查看项目分类');
		$auth->createOperation('category/create', '添加分类');
		$auth->createOperation('category/delete', '删除分类');
		$auth->createOperation('category/update', '删除分类');
		$task = $auth->createTask('categoryControl', '分类管理');
		$task->addChild('category/index');
		$task->addChild('category/create');
		$task->addChild('category/delete');
		$task->addChild('category/update');
		
		// 自定义项目参数
		$auth->createOperation('parameter/index', '自定义项目参数');
		$auth->createOperation('parameter/create', '添加参数');
		$auth->createOperation('parameter/delete', '删除参数');
		$auth->createOperation('parameter/update', '更新参数');
		$task = $auth->createTask('parameterControl', '自定义项目参数');
		$task->addChild('parameter/index');
		$task->addChild('parameter/create');
		$task->addChild('parameter/delete');
		$task->addChild('parameter/update');
		
		// 设备管理
		$auth->createOperation('device/index', '设备清单');
		$auth->createOperation('device/create', '添加设备');
		$auth->createOperation('device/delete', '删除设备');
		$auth->createOperation('device/update', '更新设备');
		$task = $auth->createTask('deviceControl', '设备管理');
		$task->addChild('device/index');
		$task->addChild('device/create');
		$task->addChild('device/delete');
		$task->addChild('device/update');
		
	}
	
	
}