<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_box table_c3">
  <tr>
    <th colspan="4"><input type="image" src="/images/button16.JPG" name="print" value="预览并打印" onclick="window.print()" class="img_dy"><?php echo $post['title'];?></th>
  </tr>
  <tr>
    <td>批号：2056556</td>
    <td>质控参数：<?php echo $post['code'];?></td>
    <td>质控月份：<?php echo $post['date'];?></td>
    <td>仪器名称：<?php echo $device->name;?></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><div id="main" style="height:400px;padding:10px;"></div></td>
  </tr>
</table>
<div class="num-time">
<?php 
	$i = 1;
	$_date = $_value = '';
	$count = count($list);
	foreach ($list as $val)
	{ 
		if($i==1)
		{
			$_date.='<dl class="data"><dt>日期：</dt>';
			$_value.='<dl class="num-t"><dt>数值：</dt>';
			$_date.='<dd>'.date('Y-m-d',$val['create_time']).' <br />'.date('H:i:s',$val['create_time']).' </dd>';
			$_value.='<dd>'.$val['value'].'</dd>';
		}else 
		{
			$_date.='<dd>'.date('Y-m-d',$val['create_time']).' <br />'.date('H:i:s',$val['create_time']).' </dd>';
			$_value.='<dd>'.$val['value'].'</dd>';
		}
		if($i%7==0)
		{
			$_date.='</dl>';
			$_value.='</dl>';
			echo $_date;
			echo $_value;
			$_date = $_value = '';
			$i=0;
		}
		$i++;	
	}
	if($count%7!=0)
	{
		$_date.='</dl>';
		$_value.='</dl>';
		echo $_date;
		echo $_value;
	}
?>
</div>
<script type="text/javascript">
    var myChart = echarts.init(document.getElementById('main'));
    myChart.setOption({
		title : {
			text: '',
			x : 'right',
			padding : '25',
			y : '-12',
			subtext: 'X=<?php echo $x;?>  SD=<?php echo $sd;?>  CV=<?php echo $cv;?>'
		},
		color : ['#4488bb'],
		animation : false,
		tooltip : {
			trigger: 'item',
			formatter: '数值:{c}'
		},
		grid : {
			x : 90,
			x2 : 10
		},
		toolbox: {
			show : false
		},
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : <?php echo $axisData;?>
			}
		],
		yAxis : [
					{
						type : 'value',
						position: 'right',
						splitNumber :60,
						precision :7,
						min : <?php echo $yAxis[-3];?>,
						max : <?php echo $yAxis[3];?>,
						//boundaryGap : [0.03,0.01],
						scale : false,
						splitLine : {
							show : false
						},
						axisLine : {show:false},
						axisLabel : {
							show : false
						}
					},
					{	

						type : 'value',
						position: 'left',
						min : -3,
						max : 3,
						splitNumber :6,
						splitLine : {
							show :true,
							lineStyle : {color: ['#f00','#fe0','#0f0','#aaa','#0f0','#fe0'], width: 1, type: 'solid'}
						},
						axisLabel : {
							formatter: function(value){
								switch(value)
								{
								case 0:
								  return "<?php echo $yAxis[0];?> \r\r\r\r\r\r\r\r\r\r X";
								  break;
								case 1:
								  return "<?php echo $yAxis[1];?> \r\r\r +1SD";
								  break;
								case 2:
								  return "<?php echo $yAxis[2];?> \r\r\r +2SD";
								  break;
								case 3:
								  return "<?php echo $yAxis[3];?> \r\r\r +3SD";
								  break;
								case -1:
								  return "<?php echo $yAxis[-1];?> \r\r\r -1SD";
								  break;
								case -2:
								  return "<?php echo $yAxis[-2];?> \r\r\r -2SD";
								  break;
								case -3:
								  return "<?php echo $yAxis[-3];?> \r\r\r -3SD";
								  break;
								}
							}
						}
					}
				],
		series : [
			{
				type:'line',
				data:<?php echo $seriesData;?>,
				markPoint : {
					data : <?php echo $outOfControlPoint ? $outOfControlPoint : '[]';?>,
					symbolSize : '3',
					symbol : 'circle',
					itemStyle: {
					    normal: {
					        color : '#ff0000',
					        label : {
					        	show : true,
					        	position : 'out'
					        }
					    }
					}
				}
			}
		]
    });
</script>