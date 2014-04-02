<?php  
$file = '/js/My97DatePicker/WdatePicker.js';
Yii::app()->clientScript->registerScriptFile($file, CClientScript::POS_BEGIN);
?>

<div id="loginmodal" style="display:none">
	<a href="#" class="flatbtn-blu hidemodal">关闭</a>
	<form id="addUser" class="user_form formular" method="post">
		<table width="650" border="0" cellspacing="0" cellpadding="0" class="table_c table_in">
			<tr>
				<td width="60">姓   名：</td>
				<td width="271"><input class="validate[required] text-input" type="text" name="Patient[name]" /></td>
				<td width="60">性   别：</td>
				<td>
					<input type="radio" name="Patient[sex]" class="wid-no validate[required]" value="2"><label for="i1">男</label>
					<input type="radio" name="Patient[sex]" class="wid-no validate[required]" value="1"><label for="i2">女</label>
				</td>
			</tr>
			<tr>
				<td>生   日：</td>
				<td><input class="validate[required,custom[date]] text-input" type="text" name="Patient[birthday]" onFocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})"/></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>手机号：</td>
				<td><input class="validate[required,custom[phone]] text-input" type="text" name="Patient[mobile]" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td>身份证号：</td>
				<td><input class="validate[required,custom[onlyLetterNumber],minSize[18],maxSize[18]] text-input" type="text" name="Patient[identity_card]" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>社保卡号：</td>
				<td><input class="validate[required,custom[onlyLetterNumber]] text-input" type="text" name="Patient[social_security_card]" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>住  址：</td>
				<td colspan="3"><input class="validate[required] text-input" type="text" name="Patient[address]" style="width:380px;" /></td>
			</tr>
			<tr>
				<td colspan="4" align="center">
				<input type="image" src="/images/button5.jpg" class="button_in2" />&nbsp;&nbsp;
				<input type="reset" class="button_in1" value="" /></td>
			</tr>
		</table>
	</form>
</div>