<?php

class SiteController extends Controller
{
	
	/**
	 * 已登录用户默认主页
	 * @var unknown
	 */
	public $returnUrl = '/record';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'width' => 74,
				'height' => 38,
				'minLength' => 4,
				'maxLength' => 4,
			),
		);
	}
	
	public function filters()
	{
		return array(
			'accessControl'	
		);
	}
	
	public function accessRules()
	{
		return array(
			array('deny',
				'users' => array('?'),
				'actions' => array('logout')
			)	
		);
	}

	public function actionIndex()
	{
		if(Yii::app()->user->getIsGuest())
		{
			$this->redirect('/site/login');
		}
		$this->redirect($this->returnUrl);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$error = Yii::app()->errorHandler->error;
		if(!empty($error))
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('/layouts/message', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/login';
		if(!Yii::app()->user->getIsGuest())
			$this->redirect($this->returnUrl);
		
		$model=new LoginForm;
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			
			if($model->validate() && $model->login())
			{
				$this->redirect($this->returnUrl);
			}
			else 
			{
				$errors = $model->getErrors();
				$error = array_pop($errors);
				Yii::app()->user->setFlash('login',$error[0]);
			}
		}
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('/site/login');
	}
	
	public function actionTest()
	{
		$this->layout = '//layouts/main';
		$this->render('test');
		
	}
	
}