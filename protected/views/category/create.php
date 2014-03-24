<div id="box">
	<h2 class="title_h2">添加分类</h2>
	<?php $this->widget('application.components.widget.Tips',array('name'=>'category'));?>
	<form id="user_form" class="user_form formular" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
			<tr>
				<td width="70">名称：</td>
				<td><input class="validate[required] text-input" type="text" name="Category[name]" /></td>
			</tr>
			<tr>
				<td width="70">是否机器检测：</td>
				<td>
					<select name="Category[automatic]" id="sport" class="validate[required]">
						<option value="<?php echo Category::AUTOMATIC_YES; ?>">是</option>
						<option value="<?php echo Category::AUTOMATIC_NO; ?>">不是</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>备&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
				<td><textarea name="Category[description]" id="textarea" cols="45" rows="5"></textarea></td>
			</tr>
			<tr>
				<td colspan="2">
				<input name="保存" type="image" value="保存" src="/images/button5.jpg" />&nbsp;&nbsp;
				<input type="reset" value="" class="button_in1" /></td>
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
</div>
