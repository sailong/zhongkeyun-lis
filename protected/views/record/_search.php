<?php  
$file = '/js/My97DatePicker/WdatePicker.js';
Yii::app()->clientScript->registerScriptFile($file, CClientScript::POS_BEGIN);
?>
<div class="search-form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

	<input name="" type="checkbox" /> &nbsp;显示未打印报告单 &nbsp;
	<?php echo $form->textField($model,'sample',array('class'=>'ss_input border_radius','placeholder'=>'请输入检测日期或患者姓名或送检医生','id'=>'e12')); ?>
	<img onclick="WdatePicker({el:'e12'})" src="/images/datePicker.Jpg" class="ss_img" align="absmiddle">
	<input type="image" src="/images/button7.jpg" />&nbsp;&nbsp;
	
<?php $this->endWidget(); ?>
</div>
	
