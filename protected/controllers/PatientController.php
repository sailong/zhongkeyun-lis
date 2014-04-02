<?php

/**
 * 病人管理
 * @author zhoujianjun
 *
 */
class PatientController extends FrontController
{
	
	/**
	 * 病人列表
	 */
	public function actionIndex()
	{
		$model = new Patient();
		$model->unsetAttributes();
		if(isset($_GET['Patient']))
			$model->attributes=$_GET['Patient'];
		$this->render('index',array('model'=>$model));
	}
	
	
	
	/**
	 * 添加病人,ajax添加是在项目检测处用到
	 */
	public function actionCreate()
	{
		$patient = new Patient();
		if(isset($_POST['Patient']))
		{
			$param = $_POST['Patient'];
			$param['birthday'] = strtotime($param['birthday']);
			$patient->attributes = $param;
			if($patient->save())
			{
				if(Yii::app()->request->getIsAjaxRequest())
				{
					$info = $patient->getAttributes();
					$info['age'] = date('Y')-date('Y', $info['birthday']);
					echo CJSON::encode(array('status'=>1,'msg'=>'添加成功', 'patient'=>$info));
				}
				else 
				{
					Yii::app()->user->setFlash('Patient','添加成功');
					$this->redirect('index');
				}
					
			}else{
				$error = array_values($patient->getErrors());
				if(Yii::app()->request->getIsAjaxRequest())
					echo CJSON::encode(array('status'=>0,'msg'=>$error[0][0]));
				else{
					
					$patient->birthday = date('Y-m-d',$param['birthday']);
					Yii::app()->user->setFalsh('Patient',$error[0][0]);
				}

// 				$errMsg = '';
//     			foreach ($patient->getErrors() as $error)
//     			{
//     				$errMsg.= $error[0].'&nbsp;&nbsp;&nbsp;';
//     			}
    			
//     			Yii::app()->user->setFlash('Patient',$errMsg);
			}
		}
		$this->render('create',array('model'=>$patient));
	}
	
	/**
	 * 供项目检测里调用
	 */
	public function actionGet()
	{
		$data = array();
		$keyword = Yii::app()->request->getParam('keyword');
		if(!empty($keyword))
		{
			$criteria=new CDbCriteria;
			if(is_numeric($keyword))
			{
				$criteria->compare('id',$this->id,true);
			}else{
				$criteria->compare('name',$this->name,true);
			}
			$result = Patient::model()->find($criteria);
		}
	}
}