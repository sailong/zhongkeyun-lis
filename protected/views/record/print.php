<!--startprint-->
<?php $patient = $model->patient;?>
<div class="bgd_box">
	<table width="685" border="0" cellspacing="0" cellpadding="0" class="report_t1">
		<tr>
			<td colspan="8" class="report_h">温泉镇社区卫生服务中心<?php echo $model->category->name;?>检验报告单</td>
		</tr>
		<tr>
			<td width="64">姓 &nbsp; 名：</td>
			<td width="79"><?php echo $patient->name;?></td>
			<td width="74">性 &nbsp;别：</td>
			<td width="76"><?php echo $patient->sex == Patient::SEX_FEMAL ? '女' : '男'; ?></td>
			<td width="75">年 &nbsp;龄：</td>
			<td width="97"><?php echo $model->patient_age;?></td>
			<td width="76">标本类型：</td>
			<td width="144"><?php echo $model->sample;?></td>
		</tr>
		<tr>
			<td>病例号：</td>
			<td>&nbsp;</td>
			<td>科 &nbsp;别：</td>
			<td><?php echo $model->department->name;?></td>
			<td>病床号：</td>
			<td><?php echo $model->bed_no;?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
			<tr>
			<td>诊 &nbsp;断：</td>
			<td><?php echo $model->diagnoses; ?></td>
			<td>送检医生：</td>
			<td><?php echo $model->doctor->name;?></td>
			<td>打印时间：</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>备 &nbsp;注：</td>
			<td colspan="7"><?php echo $model->remark;?></td>
		</tr>
	</table>
	<table width="685" border="0" cellspacing="0" cellpadding="0" class="report_t2">
		<tr>
			<th>项 &nbsp;目：</th>
			<th>代 &nbsp;号：</th>
			<th>测定值：</th>
			<th>提 &nbsp;示：</th>
			<th>单 &nbsp;位：</th>
			<th>参考值：</th>
		</tr>
		<?php foreach ($result as $item):?>
		<?php $para = $item->parameter;?>
		<tr>
			<td><?php echo $para->name;?></td>
			<td><?php echo $para->code;?></td>
			<td><?php echo $item->value;?></td>
			<td><?php echo $item->value > $para->ref_end ? '↑' : ($item->vlaue < $para->ref_start) ? '↓' : '';?></td>
			<td><?php echo $para->unit;?></td>
			<td><?php echo $para->ref_start;?>-<?php echo $para->ref_end;?></td>
		</tr>
		<?php endforeach;?>
	</table>
	<div class="report_time"><span>采集时间：<?php echo date('Y-m-d', $model->sample_time); ?></span><span>送检时间：<?php echo date("Y-m-d", $model->test_time); ?></span><span>报告时间：<?php echo date("Y-m-d", $model->reporting_time);?></span><span>检验师：<?php echo $model->operator->name;?></span><span>核对者：<?php echo $model->checker->name;?></span></div>
	<div class="butt_dy">
		<input type="image" src="/images/button16.JPG" name="print" value="预览并打印" />
	</div>
</div>
<!--endprint-->
<script type="text/javascript">

$(function(){

	var param = {
		beforePrintUrl: '<?php echo $this->createUrl('/record/beforePrint',array("id"=>$model->id, 'position'=>$position)); ?>',
		afterPrintUrl: '<?php echo $this->createUrl('/record/afterPrint',array("id"=>$model->id,'position'=>$position)); ?>'
	};

	
	// 打印之前
	window.onbeforeprint = function(){
		$.get(param.beforePrintUrl);
	}
	// 打印之后
	window.onafterprint = function(){
		$.get(param.afterPrintUrl);
	}

	// 非IE下使用
	var onPrintFinished=function(printed){
		window.onafterprint();
	}

	// 打印
	$(":image[name=print]").bind("click", function(){
		bdhtml=window.document.body.innerHTML;
		sprnstr="<!--startprint-->";
		eprnstr="<!--endprint-->";
		prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);
		prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
		window.document.body.innerHTML=prnhtml;

		if($.browser.msie || $.browser.mozilla){
			// IE浏览器,支持onbeforeprint 和 onafterprint 事件
			window.print();
		}else{
			// 非IE
			window.onbeforeprint();
			onPrintFinished(window.print());
		}
	});
	
})
</script>