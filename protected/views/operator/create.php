<?php $this->widget('application.components.widget.Tips',array('name'=>'user'));?>

<div id="box">
	<h2 class="title_h2">添加分类</h2>
	<?php $this->widget('application.components.widget.Tips',array('name'=>'user'));?>
	<form id="user_form" class="user_form formular" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
			<tr>
				<td width="80">名称：</td>
				<td><input class="validate[required] text-input" type="text" name="User[name]" /></td>
			</tr>
			<tr>
				<td width="80">编号：</td>
				<td><input class="validate[required] text-input" type="text" name="User[number]" /></td>
			</tr>
			<tr>
				<td width="80">手机号：</td>
				<td><input class="validate[required] text-input" type="text" name="User[mobile]" /></td>
			</tr>
			<tr>
				<td width="80">科室：</td>
				<td>
					<select class="validate[required]" name="User[department_id]">
						<?php foreach ($departments as $department):?>
							<option value="<?php echo $department->id;?>"><?php echo $department->name;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>密码：</td>
				<td><input class="text-input validate[required,minSize[6],maxSize[20]]" type="password" id="pwd" name="User[password]"></td>
			</tr>
			<tr>
				<td>确认密码：</td>
				<td><input class="text-input validate[condRequired[pwd],equals[pwd]]" type="password" id="form-validation-field-0" name="User[verifyPassword]"></td>
			</tr>
			<tr>
				<td>所在权限组：</td>
				<td>
					<select class="validate[required]" name="User[role]">
					<?php 
						if(!empty($roles))
							foreach ($roles as $role):
					?>
							<option value="<?php echo $role->name; ?>"><?php echo $role->description;?></option>
					<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<input name="保存" type="image" value="保存"src="/images/button5.jpg" />&nbsp;&nbsp;
				<input type="reset" value="" class="button_in1" /></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
		</table>
	</form>
</div>

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