<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	
	/**
	 * 当前用户信息
	 * @var unknown
	 */
	protected $_user = NULL;
	
	
	/**
	 * 检测当前用户是否合法
	 * @see CController::init()
	 */
	public function init()
	{
		$model = User::model()->findByPk(Yii::app()->user->id);
		if(empty($model) || $model->status != User::STATUS_NORMAL || empty(Yii::app()->user->hospital_id))
		{
			Yii::app()->user->logout();
			$this->redirect('/site/login');
		}
		$hospital = $model->hospital;
		if(empty($hospital))
		{
			Yii::app()->user->logout();
			$this->redirect('/site/login');
		}
		$this->_user = $model;
	}
	
	/**
	 * 添加表单验证脚本(如果有表单验证,则调用此函数,注意form的id是user_form
	 */
	protected function registerValidateScript()
	{
		$script = <<<EOF
$("#user_form").validationEngine({ 
	scroll:false,
	promptPosition:"centerRight",
	maxErrorsPerField:1,
	showOneMessage:true,
	addPromptClass:"formError-noArrow formError-text"
});	
EOF;
		Yii::app()->clientScript->registerScript('formValidate', $script, CClientScript::POS_END);
	}
}