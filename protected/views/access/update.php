<div id="box">
	<h2 class="title_h2">添加权限</h2>
	<?php $this->widget('application.components.widget.Tips',array('name'=>'AuthItem'));?>
	
	<?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items, 'authItem'=>$authItem)); ?>
</div>
