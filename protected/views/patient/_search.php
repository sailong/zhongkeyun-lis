<div class="search-form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

<?php echo $form->textField($model,'name',array('class'=>'ss_input border_radius','placeholder'=>'请输入...')); ?>
	<input type="image" src="/images/button7.jpg" />&nbsp;&nbsp;
	<a href="create"><img src="/images/button8.jpg" /></a>
<?php $this->endWidget(); ?>
</div>
	
