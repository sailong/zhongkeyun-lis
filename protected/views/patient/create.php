<div id="box">
<h2 class="title_h2"><a href="<?php echo $this->createUrl('index');?>">患者</a> - 添加</h2>
<?php $this->widget('application.components.widget.Tips',array('name'=>'Patient'));?>
<?php 
	CHtml::$afterRequiredLabel = '';
	$form=$this->beginWidget('CActiveForm',array(
		'id'=>'user_form',
		'action' => $this->createUrl('create'),
		'enableClientValidation'=>true,
		'errorMessageCssClass'=>'red',
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array(
			'class'=>'user_form',
		)
));
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
    <tr>
    	<td width="12%"><?php echo $form->labelEx($model,'name');?>：</td>
    	<td width="25%">
    	<?php echo $form->textField($model,'name',array('class'=>'validate[required] text-input')); ?>
    	</td>
    	<td width="12%"><?php echo $form->labelEx($model,'sex');?>：</td>
    	<td>
    	<input type="radio" name="Patient[sex]" id="i1" class="wid-no validate[required]" value="<?php echo Patient::SEX_MALE;?>"><label for="i1">男</label>
    	<input type="radio" name="Patient[sex]" id="i2" class="wid-no validate[required]" value="<?php echo Patient::SEX_FEMAL;?>"><label for="i2">女</label></td>
    </tr>
    <tr>
    	<td><?php echo $form->labelEx($model,'birthday');?>：</td>
    	<td><?php echo $form->textField($model,'birthday',array(
    															'class'=>'validate[required] text-input',
    															'onclick' => 'WdatePicker({readOnly:true})',		
    			)); ?></td>
    	<td></td>
    	<td></td>
    </tr>
    <tr>
    	<td><?php echo $form->labelEx($model,'identity_card');?>：</td>
    	<td>
    	<?php echo $form->textField($model,'identity_card',array('class'=>'validate[required,custom[chinaIdLoose]] text-input')); ?>
    	</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td> <?php echo $form->labelEx($model,'social_security_card');?> ：</td>
    	<td><?php echo $form->textField($model,'social_security_card',array('class'=>'validate[required] text-input')); ?></td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td> <?php echo $form->labelEx($model,'mobile');?> ：</td>
    	<td><?php echo $form->textField($model,'mobile',array('class'=>'validate[required,custom[mobile] text-input')); ?></td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
      	<input class="submit but-a" type="submit" value="保 存">
        &nbsp;&nbsp;<input name="" type="reset" value="重 置" class="but-a1" /></td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<br />
<br />
<br />
<br />
</div>
<script src="/js/My97DatePicker/WdatePicker.js"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#user_form").validationEngine({ 
		scroll:false,
		//binded:false,
		//showArrow:false,
		promptPosition:"centerRight",
		maxErrorsPerField:1,
		showOneMessage:true,
		addPromptClass:"formError-noArrow formError-text"
	});
	$("input[type=radio][value=<?php echo $model->sex;?>]").attr("checked",'checked')
});
</script>