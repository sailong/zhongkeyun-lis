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
			array('name'=>'name','value'=>'substr($data->name, 0, strpos($data->name,"-"))'),
			'description',
			array(
				'class'=>'application.components.widget.table.ButtonColumn',
				//'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->name))',
				//'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->name))'
			)
		)
));

?>