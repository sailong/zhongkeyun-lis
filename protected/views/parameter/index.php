<?php $this->renderPartial('_search', array('model'=>$model));?>

<?php $this->widget('application.components.widget.Tips',array('name'=>'CustomTestItem'));?>


<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			'id','name','code','unit',
			array(
				'header'=>'参考值',
				'value' => '!empty($data->ref_end) ? "$data->ref_start - $data->ref_end" : $data->ref_start'
			),
			array(
				'name'=>'category_id',
				'value'=>'$data->category->name'
			),
			array(
				'name'=>'device_id',
				'value'=>'$data->device->name'
			),
			array(
				'class'=>'application.components.widget.table.ButtonColumn',
			)
		)
));

?>