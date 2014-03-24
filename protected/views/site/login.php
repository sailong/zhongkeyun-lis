<?php 
$script = <<<EOF
$("#user_form").validationEngine({
	scroll:false,
	//binded:false,
	//showArrow:false,
	promptPosition:"centerRight",
	maxErrorsPerField:1,
	showOneMessage:true,
	//addPromptClass:"formError-noArrow formError-text"
});
EOF;

Yii::app()->clientScript->registerScript('validate',$script);
?>

<form id="user_form" class="user_form formular" method="post">
	<div class="position">
		<div class="land">
		<?php if(Yii::app()->user->hasFlash('login')):?>
			<span style="color:red"><?php echo Yii::app()->user->getFlash('login'); ?></span>
		<?php endif;?>
	    	<ul>
	        	<li>账 &nbsp; &nbsp;号：<input name="LoginForm[username]" type="text" class="validate[required] land_input" /></li>
	            <li>密 &nbsp; &nbsp;码：<input name="LoginForm[password]" type="password" class="validate[required] land_input" /></li>
	            <li>验证码：<input name="LoginForm[verifyCode]" type="text" class="land_input w_input" />
	            	<?php $this->widget('CCaptcha',array('buttonLabel'=>'换一张','imageOptions'=>array('class'=>'yzm'))); ?>
	            </li>
	            <li class="pad-le"><input name="" type="image" src="/images/button20.jpg" /></li>
	        </ul>
		</div>
	</div>
</form>
	
