<div class="time_qd">

	<?php 
		$arr = DisinfectLog::$dayTimeArr;
		$arr = array_reverse($arr,true);
		foreach ($arr as $id=>$str)
		{	
			echo '<dl class="select">';
			if($sign[$id])
			{
				echo '<dt class="cur-no">'.$str.'已签到</dt>';
			}else
			{
				$li = '<li><a href="#" hour="%s" time_id="%s">%s小时</a></li>';
				echo '<dt>'.$str.'签到</dt>';
				echo '<dd><ul>';
				for ($i=1;$i<=6;$i++)
				{
					echo sprintf($li,$i,$id,$i);
				}
				echo '</ul></dd>';
			}
			echo '</dl>';
	    }?>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_t_c">
  <tr class="bj_g">
    <td>签到日期</td>
    <td>上/下午</td>
    <td>总消毒时长</td>
    <td>消毒师</td>
  </tr>
  <?php
		$data = $dataProvider->getData();
		foreach ($data as $val)
		{
			$name = isset($userData[$val['operator_id']]) ? $userData[$val['operator_id']]['name'] : '';
	?>
  <tr>
    <td><?php echo date('Y-m-d',$val->disinfect_day);?></td>
    <td><?php echo $this->getTimeStrById($val->time_id);?></td>
    <td><?php echo $val->disinfect_hours;?></td>
    <td><?php echo $name;?></td>
  </tr>
  <?php }?>
</table>
<?php 
    $this->widget('application.components.widget.Page',array( 'pages' => $dataProvider->getPagination()));   
?> 
<script type="text/javascript">
$(function(){
	$(".select").each(function(){
		var s=$(this);
		var z=parseInt(s.css("z-index"));
		var dt=$(this).children("dt");
		var dd=$(this).children("dd");
		var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
		var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
		dt.click(function(){dd.is(":hidden")?_show():_hide();});
		dd.find("a").click(function(){
				if(confirm('您确定签到吗？'))
				{
					var hour = $(this).attr('hour');
					var time_id = $(this).attr('time_id');
					var data = sendAjax('<?php echo $this->createUrl('sign');?>',{hour:hour,time_id:time_id},'POST');
					if(data.code==1)
					{
						dt.attr('class','cur-no');
						dt.html('已签到');
						dd.remove();
						alert('签到成功');
					}else
					{
						alert(data.msg);
					}
					
				}
				_hide();
			});     //选择效果（如需要传值，可自定义参数，在此处返回对应的"value"值 ）
		$("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
	})
})
</script>
<script type="text/javascript" src="/js/common.js"></script>