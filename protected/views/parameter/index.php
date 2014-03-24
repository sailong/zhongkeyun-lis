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
			'id','name','code','unit','ref_start',
			array(
				'name'=>'category_id',
				'value'=>'$data->category->name'
			),
			array(
				'class'=>'application.components.widget.table.ButtonColumn',
			)
		)
));

?>