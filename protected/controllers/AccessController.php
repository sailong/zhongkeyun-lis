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
		if(isset($_POST['AuthItem']))
		{
			$param = $_POST['AuthItem'];
			$authItem = new Authitem();
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
			}
		}
		$items = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_TASK);
		$this->render('create',array('items'=>$items));
	}
	
	
	
	/**
	 * 初始化权限
	 */
	public function actionOne()
	{
		$auth=Yii::app()->authManager;
		
// 		$auth->createOperation('operator/index','查看用户');
// 		$auth->createOperation('operator/add','添加用户');
// 		$auth->createOperation('operator/delete','删除用户');
		
// 		$auth->createOperation('access/index','查看角色');
// 		$auth->createOperation('access/add','添加角色');
		
// 		$task = $auth->createTask('accessControl', '权限管理');
// 		$task->addChild('operator/index');
// 		$task->addChild('operator/add');
// 		$task->addChild('operator/delete');
		
// 		$task->addChild('access/index');
// 		$task->addChild('access/add');
		
//		$auth->assign('accessControl',1);

		
		
// 		$auth->createOperation('category/index', '查看项目分类');
// 		$auth->createOperation('category/create', '添加分类');
// 		$auth->createOperation('category/delete', '删除分类');
// 		$task = $auth->createTask('categoryControl', '分类管理');
// 		$task->addChild('category/index');
// 		$task->addChild('category/create');
// 		$task->addChild('category/delete');
		
// 		$auth->createOperation('parameter/index', '自定义项目参数');
// 		$auth->createOperation('parameter/create', '添加参数');
// 		$auth->createOperation('parameter/delete', '删除参数');
// 		$task = $auth->createTask('parameterControl', '自定义项目参数');
// 		$task->addChild('parameter/index');
// 		$task->addChild('parameter/create');
// 		$task->addChild('parameter/delete');
		
		//$nauth->createOperation('')
	}
	
	
}