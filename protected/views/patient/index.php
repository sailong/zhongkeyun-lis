<?php $this->renderPartial('_search', array('model'=>$model));?>

<?php $this->widget('application.components.widget.Tips',array('name'=>'Patient'));?>

<?php 
$this->widget('application.components.widget.table.Table', array(
		'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		'enableSorting'=>false,
		'pager'=>array(
			'class'=>'application.components.widget.Page'
		),
		'columns' => array(
			'id','name',
			array('name'=>'sex', 'value'=>'$data->sex == Patient::SEX_FEMAL ? "女" : "男"'),
			array('name'=>'birthday', 'value'=>'$data->birthday ? date("Y-m-d",$data->birthday):""'),
			array('header'=>'年龄','value'=>'!empty($data->birthday) ? date("Y",time()) - date("Y",$data->birthday) : ""'),
			'identity_card','social_security_card',
				
		)
));

?>