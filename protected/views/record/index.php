<?php $this->renderPartial('_search', array('model'=>$model));?>

<?php $this->widget('application.components.widget.Tips',array('name'=>'Record'));?>

<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			array(
				'header' => '姓名',
				'value'  => '$data->patient->name'
			),
			array(
				'header' => '性别',
				'value' => '$data->patient->sex == 1 ? "男" : "女"'
			),
			'patient_age',
			array(
				'header' => '送检医生',
				'value' => '$data->doctor->name'
			),
			array(
				'header' => '检验者',
				'value' => '$data->operator->name'
			),
			array(
				'header' => '核对者',
				'value' => '$data->checker->name'
			),
			array(
				'header' => '检验时间',
				'value' => 'date("Y-m-d H:i",$data->test_time)'
			),
			array(
				'class'=>'application.components.widget.table.ButtonLinkColumn',
			)
		)
));

?>