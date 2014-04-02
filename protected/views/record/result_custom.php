<?php echo $this->renderPartial('_result',array('model'=>$model));?>

<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$dataProvider,
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			array('header'=>'项目名称','value'=>'$data->parameter->name'),
			array('header'=>'代号','value'=>'$data->parameter->code'),
			array('header'=>'字符测值','value'=>'$data->value'),
		)
));

?>