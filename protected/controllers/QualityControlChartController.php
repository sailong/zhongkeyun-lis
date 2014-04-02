<?php
/**
 * 绘制质控图
 * @author wyj
 *
 */
header('content-type:text/html;charset=utf-8');
class QualityControlChartController extends FrontController
{
	public $pageTitle = '绘制质控图';
	/**
	 * 列表
	 */
	public function actionIndex()
	{
		$condition = ' hospital_id = '.Yii::app()->user->hospital_id;
		$data['deviceData'] = Device::model()->findAll($condition);
		$data['sampleCategory'] = QualityControlSampleCategory::model()->findAll();
		$this->render('index',$data);
	}
	/**
	 * 图表展示
	 */
	public function actionShowChart()
	{
		$deviceId = Yii::app()->request->getParam('deviceId',0);
		$sampleCategoryId = Yii::app()->request->getParam('sampleCategoryId',0);
		$code = Yii::app()->request->getParam('code','');
		$date = Yii::app()->request->getParam('date',0);
		$title = Yii::app()->request->getParam('title','');
		if(!$deviceId || !$sampleCategoryId || !$code || !$date || !$title) Util::returnAjax('参数错误');
		$data['device'] = Device::model()->findByPk($deviceId);
		if(!$data['device']) Util::returnAjax('没有找到该设备数据');
		//计算月份天数
		$monthDays = date('t',strtotime($date));
		
		$qcResultModel = QualityControlResult::model();
		
		$list = $qcResultModel->getQCResult($deviceId, $sampleCategoryId, $code, $date);
		//获取质控值
		$qcValueArr = $dayQcValueArr = $lineQcValueArr = $yAxisArr = array();
		if($list)
		{
			foreach ($list as $val)
			{
				$qcValueArr[] = $val['value'];
				$day = ltrim(date('d',$val['create_time']),0);
				$dayQcValueArr[$day][] = $val['value'];
			}
		}
		//计算平均数 标准差  cv
		$data['x'] = $qcResultModel->getAverage($qcValueArr);
		$data['sd'] = $qcResultModel->getSD($qcValueArr);
		$data['cv'] = $qcResultModel->getCV($data['sd'],$data['x']);
		//-------------------------------------------------------------------
		if($dayQcValueArr)
		{
			uksort($dayQcValueArr, create_function('$a, $b', 'if ($a == $b) return 0; return ($a > $b) ? 1 : -1;'));
		}
		//-------------------------------------------------------------------
		$data['axisData'] = $this->getAxisData($monthDays);
		$data['seriesData'] = $this->getSeriesData($dayQcValueArr,$monthDays);
		$data['yAxis'] = $this->getYaxis($data['x'], $data['sd']);
		$data['post'] = $_POST;
		$data['list'] = $list;
		$data['outOfControlPoint'] = $this->getOutOfControlPoint($dayQcValueArr, $data['sd'], $data['x']);
		
		
		$this->renderPartial('chart',$data);
	}
	
	
	public function actionGetDeviceReleateData()
	{
		$deviceId = Yii::app()->request->getParam('deviceId',0);
		if(!$deviceId) Util::returnAjax(0);
		//获取设备项目参数
		$device = Device::model()->findByPk($deviceId);
		if(!$device ||!$device->category_id ) Util::returnAjax(0,'找不到设备数据');
		
		$data['item'] = $data['sampleCategory'] = '';
		$item = CustomTestItem::model()->findAllByAttributes(array('category_id' => $device->category_id));
		foreach ($item as $it)
		{
			$data['item'].='<option value='.$it->code.'>'.$it->name.'['.$it->code.']</option>';
		}
		/* $category = QualityControlSampleCategory::model()->findAll();
		foreach ($category as $cate)
		{
			$data['sampleCategory'].='<option value='.$cate->id.'>'.$cate->name.'</option>';
		} */
		//获取质控品
		Util::returnAjax(1,'',$data);
	}
	
	/**
	 * 获取y轴数据
	 * @param unknown_type $x
	 * @param unknown_type $sd
	 * @return number
	 */
	private function getYaxis($x,$sd)
	{
		for ($i=-3;$i<=3;$i++)
		{
			$arr[$i] = $x + $i * $sd;
		}
		return $arr;
	}
	/**
	 * 获取曲线图数据
	 * @param string $dayQcValueArr
	 */
	private function getSeriesData($dayQcValueArr,$monthDays)
	{
		$arr = array();
		foreach ($dayQcValueArr as $day=>$val)
		{
			$arr[$day] = end($val);
		}
		for($i=1;$i<=$monthDays;$i++)
		{
			if (!isset($arr[$i])) $arr[$i] = "'-'";
		}
		//数组排序
		ksort($arr);
		return '['.implode(',', $arr).']';
	}
	/**
	 * X轴显示数据
	 * @param unknown_type $monthDays
	 * @return string
	 */
	private function getAxisData($monthDays)
	{
		$arr = range(1, $monthDays);
		return '['.implode(',', $arr).']';
	}
	/**
	 * 获取失控点
	 */
	private function getOutOfControlPoint($dayQcValueArr,$sd,$x)
	{
		if(!$dayQcValueArr) return;
		$arr = $last = array();
		$last['yAxis'] = $x;
		$warnLine_top = $x + 2*$sd;
		$warnLine_bottom = $x - 2*$sd;
		$outLine_top = $x + 3*$sd;
		$outLine_bottom = $x - 3*$sd;
		
		foreach ($dayQcValueArr as $day=>$value)
		{
			foreach ($value as $v)
			{
				$key = $day.'-'.$v;
				if($v >= $warnLine_bottom && $v <= $warnLine_top) continue;
				//超过 +-3S
				if($v > $outLine_top || $v < $outLine_bottom)
				{
					$arr[$key] = array('xAxis' => $day, 'yAxis' => $v,'value' => $v);
				}else
				{
					//两个连续的质控结果同时超过均值+2s 或均值-2s ， 就判断失控
					if( ($v > $warnLine_top || $v < $warnLine_bottom) && ($last['yAxis'] > $warnLine_top || $last['yAxis'] < $warnLine_bottom) )
					{
						$arr[$last['xAxis'].'-'.$last['yAxis']] = $last;
						$arr[$key] = array('xAxis' => $day, 'yAxis' => $v,'value' => $v);
					}
				}
				$last['xAxis'] = $day;
				$last['yAxis'] = $last['value'] = $v;
			}
		}
		if($arr)
		{
			shuffle($arr);
			$str = json_encode($arr);
			$str = str_replace(array('"'), array(''),$str);
			return $str;
		}
		return;
	}
}