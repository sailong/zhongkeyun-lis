<?php

/**
 * 结合Yii::app()->user->hasFlash()显示提示信息
 * @author zhoujianjun
 *
 */
class Tips extends CWidget
{
	
	/**
	 * flash信息名称
	 * @var str
	 */
	public $name = 'message';
	
	/**
	 * 显示提示信息后,是否删除该信息
	 * @var unknown
	 */
	public $remove = true;
	
	/**
	 * 信息显示时间,默认5秒钟
	 * @var unknown
	 */
	public $timeout = 5000;
	
	/**
	 * 提示信息的id
	 * @var unknown
	 */
	public $id = 'message_tip';
	
	public function init()
	{
		if($this->remove)
			$this->registerClientScript();
	}
	
	public function run()
	{
		if(Yii::app()->user->hasFlash($this->name))
		{
			echo '<div class="alert alert-error" id="'.$this->id.'">';
			echo Yii::app()->user->getFlash($this->name);
			echo '</div>';
		}
	}
	
	/**
	 * 
	 */
	private function registerClientScript()
	{
		$script = <<<EOF
$(function(){
	setTimeout(function(){
		$("#{$this->id}").remove();
	},{$this->timeout});		
})	
EOF;
		Yii::app()->clientScript->registerScript($this->id, $script, CClientScript::POS_END);
		
	}
	
}