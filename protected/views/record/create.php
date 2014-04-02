<?php $this->renderPartial('_search_add');?>
<?php 
$clientScript = Yii::app()->clientScript;
$file = '/js/My97DatePicker/WdatePicker.js';
$file2 = '/js/jquery.leanModal.min.js';

$clientScript->registerScriptFile($file, CClientScript::POS_BEGIN);
$clientScript->registerScriptFile($file2, CClientScript::POS_END);
?>
<form id="userCheck" class="user_form formular" method="post">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c">
		<tr>
			<td colspan="6"><h2>基本信息</h2></td>
		</tr>
		<tr>
			<td>I     D：</td>
			<td><input name="Record[patient_id]" type="text" readonly="readOnly" class="text-input"></td>
			<td>姓    名：</td>
			<td><input class="validate[required] text-input" type="text" name="name" readonly="readOnly"></td>
			<td>年    龄：</td>
			<td><input class="validate[required] text-input" type="text" name="Record[patient_age]" style="width:80px;">
					<select class="sui" >
						<option value="1">岁</option>
						<option value="2">月</option>
						<option value="3">天</option>
					</select>
			</td>
	  	</tr>
	  
		<tr>
    		<td>科    别：</td>
    		<td>
    			<select class="validate[required]" name="Record[department_id]">
					<?php foreach ($departments as $department):?>
						<option value="<?php echo $department->id;?>"><?php echo $department->name;?></option>
					<?php endforeach;?>
				</select>
    		
    		</td>
			<td>床    号：</td>
			<td><input class="validate[required] text-input" type="text" name="Record[bed_no]"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>标本类型：</td>
			<td><input class="validate[required] text-input" type="text" name="Record[sample]"></td>
			<td>送检医生：</td>
			<td>
				<select class="validate[required]" name="Record[doctor_id]">
					<?php foreach ($doctores as $doctor):?>
						<option value="<?php echo $doctor->id;?>"><?php echo $doctor->name;?></option>
					<?php endforeach;?>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>临床诊断：</td>
			<td><input class="validate[required] text-input" type="text" name="Record[diagnoses]" /></td>
			<td>检验组合：</td>
			<td><input class="validate[required] text-input" type="text" name="Record[test_item]" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>设备型号：</td>
			<td>
				<select class="validate[required]" name="Record[device_id]">
					<?php foreach ($devices as $device):?>
						<option value="<?php echo $device->id;?>"><?php echo $device->name;?></option>
					<?php endforeach;?>			
				</select>
			</td>
			<td>报告单格式：</td>
			<td>
				<select class="validate[required]" name="Record[category_id]">
					<?php foreach ($categorys as $category):?>
						<option value="<?php echo $category->id;?>"><?php echo $category->name;?>报告单</option>
					<?php endforeach;?>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>检验师：</td>
			<td>
				<select class="validate[required]" name="Record[operator_id]">
				<?php foreach ($operators as $operator):?>
					<option value="<?php echo $operator->id;?>"><?php echo $operator->name; ?></option>
				<?php endforeach;?>
				</select>
			</td>
			<td>核对者：</td>
			<td>
				<select class="validate[required]" name="Record[checker_id]">
				<?php foreach ($operators as $operator):?>
					<option value="<?php echo $operator->id;?>"><?php echo $operator->name; ?></option>
				<?php endforeach;?>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>采样时间：</td>
			<td><input class="inp Wdate" type="text" name="Record[sample_time]" onClick="WdatePicker()" /></td>
			<td>送检时间：</td>
			<td><input class="inp Wdate" type="text" name="Record[test_time]" onClick="WdatePicker()" /></td>
			<td>报告时间：</td>
			<td><input class="inp Wdate" type="text" name="Record[reporting_time]" onClick="WdatePicker()" /></td>
		</tr>
		<tr>
			<td>备    注：</td>
			<td colspan="5"><textarea name="Record[remark]" rows="3" class="textarea"></textarea></td>
		</tr>
	</table>
	<div class="button_c">
		<input type="image" src="/images/button1.jpg" name="check" />
		<input type="image" src="/images/button18.JPG" />
	</div>
</form>

<?php echo $this->renderPartial("_add_user");?>


<?php echo $this->renderPartial('_script');?>