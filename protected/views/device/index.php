<?php $this->renderPartial('_search', array('model'=>$model));?>

<?php $this->widget('application.components.widget.Tips',array('name'=>'device'));?>

<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			'id','name','number','producer',
			array(
				'name' => 'production_date',
				'value' => 'date("Y-m-d",$data->production_date)'
			),
			array(
				'name' => 'release_date',
				'value' => 'date("Y-m-d",$data->release_date)'
			),
			'standard','remark',
			array(
				'class'=>'application.components.widget.table.ButtonColumn',
			)
		)
));

?>