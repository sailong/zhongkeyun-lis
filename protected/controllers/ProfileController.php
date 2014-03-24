<?php

/**
 * 账号设置
 * @author JZLJS00
 *
 */
class ProfileController extends FrontController
{
	
	/**
	 * 修改密码
	 */
	public function actionPassword()
	{
		if(isset($_POST['User']))
		{
			$param = $_POST['User'];
			if($param['password'] != $param['repeatPassword'])
			{
				Yii::app()->user->setFlash('password', '两次输入密码不一致');
			}
			if(md5($param['originalPassword']) != $this->_user->password)
			{
				Yii::app()->user->setFlash('password', '原始密码错误');
			}
			$this->_user->password = md5(trim($param['password']));
			$this->_user->update(array('password'));
			Yii::app()->user->setFlash('password', '密码更改成功');
		}
		$this->render('password');
	}
	
}