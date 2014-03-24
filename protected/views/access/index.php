<?php $this->renderPartial('_search', array('model'=>$model));?>

<?php $this->widget('application.components.widget.Tips',array('name'=>'AuthItem'));?>

<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			'description','remark',
			array(
				'class'=>'application.components.widget.table.ButtonColumn',
			)
		)
));

?>