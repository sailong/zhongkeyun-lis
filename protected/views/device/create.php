<?php  
$file = '/js/My97DatePicker/WdatePicker.js';
Yii::app()->clientScript->registerScriptFile($file, CClientScript::POS_BEGIN);
?>

<div id="box">
	<h2 class="title_h2">添加设备</h2>
	<?php $this->widget('application.components.widget.Tips',array('name'=>'device'));?>
	
	<form id="user_form" class="user_form formular" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
			<tr>
				<td>类别：</td>
				<td>
					<select name="Device[category_id]" class="validate[required]">
						<?php foreach ($categorys as $category):?>
							<option value="<?php echo $category->id; ?>"><?php echo $category->name;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="80">名称：</td>
				<td><input class="validate[required] text-input" type="text" name="Device[name]" /></td>
				</tr>
			<tr>
				<td>型号：</td>
				<td><input class="validate[required] text-input" type="text" name="Device[number]" /></td>
			</tr>
			<tr>
				<td>厂家：</td>
				<td><input class="validate[required] text-input" type="text" name="Device[producer]" /></td>
			</tr>
			<tr>
				<td>生产日期：</td>
				<td>
					<input class="validate[required] text-input" type="text" name="Device[production_date]" onFocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})" />
				</td>
			</tr>
			<tr>
				<td>出厂日期：</td>
				<td>
					<input class="validate[required] text-input" type="text" name="Device[release_date]" onFocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})" />
				</td>
			</tr>
			<tr>
				<td>规格：</td>
				<td><input class="validate[required] text-input" type="text" name="Device[standard]" /></td>
			</tr>
			  
			<tr>
				<td>备&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
				<td><textarea name="Device[remark]" cols="45" rows="5"></textarea></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="image" value="保存" src="/images/button5.jpg" />&nbsp;&nbsp;
					<input name="" type="reset" value="" class="button_in1" />
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		</table>
	</form>
</div>