<?php

class Util
{
	
	/**
	 * 检测是否是手机号
	 */
	public static function checkIsMobile($mobile)
	{
		return preg_match('/^(13|14|15|18)\d{9}$/', $mobile) ? true : false;
	}
	
	public static function getKey($key)
	{
		return md5(Yii::app()->getId().$key);
	}
	
	/**
	 * 存储cookie
	 * @param unknown_type $name
	 * @param unknown_type $value
	 * @param unknown_type $expire
	 */
	public static function addCookie($name,$value,$expire=0)
	{
		$key=self::getKey($name);
		$value = Yii::app()->getSecurityManager()->hashData($value);
		Yii::app()->getRequest()->cookies->add(new CHttpCookie($key, $value,array('expire'=>$expire)));
	}
	/**
	 * 获取cookie
	 * @param unknown_type $name
	 */
	public static function getCookie($name)
	{
		$key = self::getKey($name);
		$cookie = Yii::app()->getRequest()->getCookies()->itemAt($key);
		if($cookie && !empty($cookie->value) && is_string($cookie->value) && ($value=Yii::app()->getSecurityManager()->validateData($cookie->value))!==false)
		{
			return $value;
		}
		return false;
	}
	/**
	 * 清除cookie
	 * @param unknown_type $name
	 */
	public static function removeCookie($name)
	{
		$key = self::getKey($name);
		Yii::app()->getRequest()->cookies->remove($key);
	}
	
	/**
	 * 通过cookie增加一个验证参数
	 */
	public static function addSign()
	{
		$key = self::getKey(time());
		self::addCookie('sign', $key);
	}
	/**
	 * 获取验证参数
	 * @return Ambigous <boolean, string>
	 */
	public static function getSign()
	{
		return self::getCookie('sign');
	}

	/**
	 * 返回ajax请求数据
	 * @param unknown_type $code
	 * @param unknown_type $msg
	 * @param unknown_type $returnData
	 */
	public static function returnAjax($code,$msg='',$returnData='')
	{
		$data['code']     = $code;
		$data['msg']      = $msg;
		$data['data']     = $returnData;
		echo json_encode($data);
		die;
	} 
	
	
}
