<div class="search-form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'search',
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

<?php echo CHtml::textField('keyword', '', array('class'=>'ss_input border_radius','placeholder'=>'请输入用户ID或姓名')); ?>
	<input type="image" src="/images/button7.jpg" name="search"/>&nbsp;&nbsp;
	<a href="#loginmodal" id="modaltrigger"><img src="/images/button8.jpg" /></a>
<?php $this->endWidget(); ?>
</div>
	
