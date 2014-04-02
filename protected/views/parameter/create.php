<div id="box">
	<h2 class="title_h2">添加自定义检测项目</h2>
	<?php $this->widget('application.components.widget.Tips',array('name'=>'CustomTestItem'));?>
	
	<?php echo $this->renderPartial('_form',array('categorys'=>$categorys,'model'=>$model)); ?>
</div>
