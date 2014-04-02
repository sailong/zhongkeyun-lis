<?php $this->renderPartial('_search', array('model'=>$model));?>

<?php $this->widget('application.components.widget.Tips',array('name'=>'User'));?>

<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			'id','name','number','mobile',
			array(
				'name' => 'department_id',
				'value' => '$data->department->name'
			),
			array(
				'header' => '权限组',
				'value' => '!empty($data->role) ? substr($data->role->itemname, 0, strpos($data->role->itemname,"-")) : ""'
			),
			array(
				'class'=>'application.components.widget.table.ButtonColumn',
			)
		)
));

?>
