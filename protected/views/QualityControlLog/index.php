<div id="box">
<form id="search_form" action="<?php echo $this->createUrl('index');?>" method="post">
<div class="title_sel">
<label><span>质控月份：</span>
<input type="text" name="date" class="validate[required] Wdate" id="date" onclick="WdatePicker({dateFmt:'yyyy-MM',maxDate:'%y-%M-%d'})"/>
</label>
<label>
<span>仪器名称：</span>
<?php echo CHtml::dropDownList('deviceId', '', CHtml::listData($deviceData, 'id', 'name'),array(
																								'empty'=>'请选择',
																								'class'=>'validate[required]',
																								'id'=>'deviceId',
																								));?>
</label>
<label>
<span>级别：</span>
 <?php echo CHtml::dropDownList('sampleCategoryId', '', CHtml::listData($sampleCategory, 'id', 'name'),array(
 																								'empty'=>'请选择',
																								'class'=>'validate[required]',
																								'id'=>'sampleCategoryId',
																								'onchange'=>"showData(this.value)"
																								));?>
</label>
<label>
<span>批号：</span>
<select name="sampleNumber" id="sampleNumber" class="validate[required]">

</select>
</label>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:;" onclick="$('form').submit();"><img src="/images/button7.JPG" /></a>
</div>
</form>
<div id="fatie">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_box list_t_c options">
  <tr class="bj_g">
    <td>ID</td>
    <td>测试时间</td>
    <td> WBC </td>
    <td> RBC </td>
    <td> HCT</td>
    <td> MCV </td>
    <td> PLT </td>
    <td> Lymph# </td>
    <td> Gran# </td>
    <td> Lymph% </td>
  </tr>
  <tr>
    <td>1</td>
    <td> 2013-11-5 14:20:00 </td>
    <td> 5.63 </td>
    <td> 5.63 </td>
    <td> 182 </td>
    <td>31.4</td>
    <td>31.4</td>
    <td>31.4</td>
    <td>31.4</td>
    <td>31.4</td>
  </tr>
</table>
</div>
</div>
<script src="/js/My97DatePicker/WdatePicker.js"></script>
<script src="/js/common.js"></script>
<script language=javascript>
jQuery(document).ready(function(){
	jQuery("#search_form").validationEngine({ 
		scroll:false,
		promptPosition:"centerRight",
		maxErrorsPerField:1,
		showOneMessage:true,
		addPromptClass:"formError-noArrow formError-text",
	});
	//$('#sampleCategoryId,#deviceId').prepend('<option value="">请选择</option>').val('');
});
function showData(id)
{
	if(!id) return;
	var data = sendAjax('<?php echo $this->createUrl('getSampleNumber');?>',{sampleCategoryId:id});
	$('#sampleNumber').html(data.data);
}

</script>