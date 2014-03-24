<?php $this->beginContent('//layouts/main'); ?>
<div class="head">
	    <div class="head_r">
	    	<a href="javascript:;" class="fore1">您好：<?php echo Yii::app()->user->name;?>，欢迎登陆!</a>
	        <a href="/profile/password" class="fore2">修改密码</a>
	        <a href="<?php echo $this->createUrl('site/logout'); ?>" class="fore3">退出登陆</a>
	    </div>
	    <a href="/"><img src="/images/logo.jpg" /></a>
</div>
	
	<?php $this->widget('application.components.widget.menu.Menu');?>
	
<div class="right">
	<?php echo $content; ?>
</div>

<?php $this->endContent(); ?>