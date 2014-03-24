<?php 
	if(!empty($devices) && count($devices)>1)
	{
		
		echo '<tr>
				<td>选择设备：</td>
				<td>';
		echo '<select name="CustomTestItem[device_id]" class="validate[required]">';
		foreach ($devices as $device)
			echo '<option value="'.$device->id.'">'.$device->name.'('.$device->number.')</option>';
		
		echo '</select>
				</td>
			</tr>';
		
	}else{

		$device_id = empty($devices) ? 1 : $devices[0]->id;
		
		echo '<tr style="display:none">
				<td></td>
				<td>';
		echo '<input type="hidden" name="CustomTestItem[device_id]" value="'.$device_id.'"/>';
		
		echo '</td>
			</tr>';
		
	}
?>