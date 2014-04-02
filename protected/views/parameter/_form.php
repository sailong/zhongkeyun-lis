<form id="user_form" class="user_form formular" method="post">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
		<tr>
			<td>类别：</td>
			<td>
				<select name="CustomTestItem[category_id]" class="validate[required]">
					<?php foreach ($categorys as $category):?>
						<option value="<?php echo $category->id; ?>" <?php if($model->category_id == $category->id):?> selected="selected" <?php endif;?>><?php echo $category->name;?></option>
					<?php endforeach;?>		
				</select>
			</td>
		</tr>
		<tr>
			<td width="80">名称：</td>
			<td><input value="<?php echo $model->name;?>" class="validate[required] text-input" type="text" name="CustomTestItem[name]" /></td>
		</tr>
		<tr>
			<td>代号：</td>
			<td><input value="<?php echo $model->code;?>" class="validate[required] text-input" type="text" name="CustomTestItem[code]" /></td>
		</tr>
		<tr>
			<td>单位：</td>
			<td><input value="<?php echo $model->unit;?>" class="validate[required] text-input" type="text" name="CustomTestItem[unit]" /></td>
		</tr>
		<tr>
			<td>参考值：</td>
			<td>
				<input class="validate[required] ss_input" type="text" name="CustomTestItem[ref_start]" placeholder="起始值" value="<?php echo $model->ref_start;?>" /> - &nbsp;
				<input class="ss_input" type="text" name="CustomTestItem[ref_end]" placeholder="终止值" value="<?php echo $model->ref_end;?>" />
			</td>
		</tr>
		<tr>
			<td>结果范围：</td>
			<td><input class="ss_input" type="text" name="CustomTestItem[range]" placeholder="多个值用分号隔开" value="<?php echo $model->range;?>"/></td>
		</tr>
		  
		<tr>
			<td>备&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
			<td><textarea name="CustomTestItem[remark]" cols="45" rows="5"><?php echo $model->remark;?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">
				<input name="保存" type="image" value="保存" src="/images/button5.jpg" />&nbsp;&nbsp;
				<input type="reset" value="" class="button_in1" />
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
$(function(){
	var device = {
	
		getCategoryId: function(){
			return $("select[name='CustomTestItem[category_id]']").val();
		},	
		
		getDevice: function(){
			var category_id = this.getCategoryId();
			$.get('/parameter/getDevice/category_id/'+category_id, function(result){
				if(result.status ==1){
					if($("table tr:eq(1)").find("[name='CustomTestItem[device_id]']").length==0)
						$("table tr:first").after(result.msg);
					else
					{
						$("table tr:eq(1)").replaceWith(result.msg);
					}
				}
			},'json');
		},

	};

	device.getDevice();

	$("select[name='CustomTestItem[category_id]']").bind("change",function(){
		device.getDevice();
	});
	
})
</script>