<?php

/**
 * 左侧菜单栏
 * @author zhoujianjun
 *
 */
class Menu extends CWidget
{
	
	/**
	 * 当前选中的菜单的类标识
	 * @var str
	 */
	public $currentClass = 'cur_l';
	
	/**
	 * 全部菜单
	 * @var array
	 */
	protected $menus = array();
	
	/**
	 * 当前操作controller id
	 * @var str
	 */
	public $currentControllerId = null;
	
	/**
	 * 当前操作action id
	 * @var str
	 */
	public $currentActionId = null;
	
	/**
	 * 显示当前日期的id标识
	 * @var unknown
	 */
	public $datetimeId = 'nowTime';
	
	/**
	 * 菜单所在div的id
	 * @var unknown
	 */
	public $menuId = 'my_menu';
	
	
	/**
	 * 初始化,加载菜单
	 * @see CWidget::init()
	 */
	public function init()
	{
		$this->menus =  require __DIR__.'/param.php';
		$controller = $this->getOwner();
		$this->currentControllerId = $controller->getId();
		$this->currentActionId = $controller->getAction()->getId();
	}
	
	
	public function run()
	{
		$html = '<div class="left_box sdmenu" id="'.$this->menuId.'">
					<h1 class="time" id="'.$this->datetimeId.'"></h1>';
		foreach ($this->menus as $menu)
		{
			$html .= PHP_EOL.'<div>'.PHP_EOL.'<h2>'.$menu['title'].'</h2>';
			if(!empty($menu['children']))
			{
				foreach ($menu['children'] as $child)
				{
					$current = explode('/', $child['id']);
					if($current[0] == $this->currentControllerId && $current[1] == $this->currentActionId)
						$html .= PHP_EOL .'<li class="'.$this->currentClass.'"><a href="'.$child['id'].'" class="icon_'.$child['class'].'">'.$child['title'].'</a></li>';
					else 
						$html .= PHP_EOL . '<li><a href="'.$child['id'].'" class="icon_'.$child['class'].'">'.$child['title'].'</a></li>';
				}
			}
			
			$html .= PHP_EOL . '</div>';
		}
		$html .= PHP_EOL.'</div>';
		$this->registerClientScript();
		echo $html;
	}
	
	private function registerClientScript()
	{
		$clientScript = Yii::app()->clientScript;
		$clientScript->registerScriptFile('/js/sdmenu.js');
		
		$script = <<<EOF
function current(){
	var d=new Date(),str=''; 
	str +=d.getFullYear()+'年'; 
	str +=d.getMonth()+1+'月'; 
	str +=d.getDate()+'日'; 
	str +=d.getHours()+':'; 
	str +=d.getMinutes()+':'; 
	str +=d.getSeconds()+''; 
	return str; 
} 
setInterval(function(){jQuery("#{$this->datetimeId}").html(current)},1000);
		
(function(){
	$(function(){
		var myMenu = new SDMenu("{$this->menuId}");
		myMenu.init();
	})
})()
		
EOF;
		$clientScript->registerScript('datetime', $script, CClientScript::POS_END);
	}
	
}