<div id="box">
	<h2 class="title_h2">添加权限</h2>
	<?php $this->widget('application.components.widget.Tips',array('name'=>'AuthItem'));?>
	
	<form id="user_form" class="user_form formular" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
			<tr>
				<td width="70">ID：</td>
				<td><input class="validate[required] text-input" type="text" name="AuthItem[name]" placeholder="请输入对应的英文"/></td>
			</tr>
			<tr>
				<td width="70">权限组名：</td>
				<td><input class="validate[required] text-input" type="text" name="AuthItem[description]"/></td>
			</tr>
			<tr>
				<td>备&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
				<td><textarea cols="45" rows="5" name="AuthItem[remark]"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" class="fxk">
				<?php foreach ($items as $key => $item):?>
					<input type="checkbox" name="AuthItem[access][]" value="<?php echo $item->name;?>" />&nbsp;&nbsp;<label><?php echo $item->description;?></label>
				<?php endforeach;?>
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
		</table>
	</form>
</div>
