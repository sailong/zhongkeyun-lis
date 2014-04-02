<style>
	@media print{
		#search_form,.head,#my_menu,.img_dy{display: none}
		body {background-color:#fff}
		.right{padding:0;margin:0}
		.table_box {border:0}
	}
</style>
<script src="/js/charts/echarts-plain.js"></script>
<form id="search_form">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_box table_c2">
  <tr>
    <th colspan="8">L-J质控（按平均值）</th>
  </tr>
  <tr>
    <td>设备：</td>
    <td>
	<select name="deviceId" id="deviceId" class="validate[required]" onchange="showData(this.value);">
      <option value="">请选择</option>
      <?php foreach ($deviceData as $d){?>
      <option value="<?php echo $d->id;?>"><?php echo $d->name;?></option>
     <?php }?>
    </select>
	</td>
	<td>项目：</td>
    <td>
	    <select name="code" id="code" class="validate[required]">
		</select>
	</td>
    <td>质控品：</td>
    <td>
    <select name="sampleCategoryId" id="sampleCategoryId" class="validate[required]">
    	<?php foreach ($sampleCategory as $d){?>
      		<option value="<?php echo $d->id;?>"><?php echo $d->name;?></option>
     	<?php }?>
    </select>
    </td>
    <td>日期范围：</td>
    <td><input type="text" name="date" class="validate[required] Wdate" id="d413" onclick="WdatePicker({dateFmt:'yyyy-MM',maxDate:'%y-%M-%d'})" value="<?php echo date('Y-m');?>"/></td></tr>
  <tr>
    <td>标题：</td>
    <td colspan="3"><input class="validate[required] text-input" style="width:400px" name="title" id="title" type="text" maxlength="200" value="温泉镇社区卫士服务中心单参数质控图"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" class="print">
	    <a href="javascript:;" onclick="$('form').submit();"><img src="/images/button15.JPG" /></a>
    </td>
  </tr>
</table>
</form>
<div id="showChart" style="text-align:center;"></div>
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
		onValidationComplete:function(form, valid){if(valid){showCharts();return false;}}
	});
});
function showData(deviceId)
{
	if(!deviceId) return;
	var data = sendAjax('<?php echo $this->createUrl('GetDeviceReleateData');?>',{deviceId:deviceId});
	if(data.code==1)
	{
		$('#code').html(data.data.item);
		//$('#sampleCategoryId').html(data.data.sampleCategory);
	}
}

function showCharts()
{
	$('#showChart').html('<img src="/images/loading.gif" />');
	var data = sendAjax('<?php echo $this->createUrl('showChart');?>',$('form').serialize(),'post','html');
	$('#showChart').html(data);

}
</script>