<?php $this->widget('application.components.widget.Tips',array('name'=>'QualityControlChannel'));?>
<form id="form1" runat="server" method="post" action="<?php echo $this->createUrl('SaveData');?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tab" class="table_box list_t_c">
  <tr>
    <td colspan="3" class="single">设备：
    <select name="deviceId" id="sport2" class="validate[required]" onchange="showSample(this.value)">
      <option value="0">请选择</option>
      <?php foreach ($deviceData as $d){?>
      <option value="<?php echo $d->id;?>"><?php echo $d->name;?></option>
     <?php }?>
    </select></td>
  </tr>
  <tr class="bj_g">
  
    <td width="10%">ID</td>
    <td width="20%">质控品</td>
    <td width="30%">通道</td>
  </tr>
  <?php foreach ($sampleData as $sam){?>
  <tr class="tag_a">
    <td><?php echo $sam->id;?></td>
    <td><?php echo $sam->name;?></td>
    <td><input value="<?php echo isset($channelData[$sam->id]) ? $channelData[$sam->id]['channel'] : '';?>" class="text-input" type="text" name="channel[<?php echo $sam->id;?>]"></td>
  </tr>
  <?php } ?>
</table>

<div class="button_c">
 <input type="image" id="" value="add" src="/images/button3.jpg"/>
</div>
</form>
<script>
var deviceId = '<?php echo $deviceId;?>';
if(deviceId) $('#sport2').val(deviceId);
function showSample(value)
{
	if(value > 0)
	{
		location.href='<?php echo $this->createUrl('index');?>/deviceId/'+value;
	}
}
</script>