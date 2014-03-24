<form id="user_form" class="user_form formular" method="post">
	<?php if(Yii::app()->user->hasFlash('password')):?>
		<span style="color:red"><?php echo Yii::app()->user->getFlash('password'); ?></span>
	<?php endif;?>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
		<tr>
			<td width="80">旧密码：</td>
			<td><input value="" class="validate[required] text-input" type="password" name="User[originalPassword]" /></td>
		</tr>
		<tr>
			<td>新密码：</td>
			<td><input class="text-input validate[required,minSize[6],maxSize[20]]" type="password" id="pwd" name="User[password]" /></td>
		</tr>
		<tr>
			<td>再输密码：</td>
			<td><input class="text-input validate[condRequired[pwd],equals[pwd]]" type="password" id="form-validation-field-0" name="User[repeatPassword]"></td>
		</tr>
		<tr>
			<td colspan="2">
			<input name="保存" type="image" value="保存"src="/images/button5.jpg" />&nbsp;&nbsp;
			<input name="重置" type="image" value="重置" src="/images/button6.jpg" /></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</form>

<script>
jQuery(document).ready(function(){
	jQuery("#user_form").validationEngine({ 
		scroll:false,
		promptPosition:"centerRight",
		maxErrorsPerField:1,
		showOneMessage:true,
		addPromptClass:"formError-noArrow formError-text"
	});
});
</script>