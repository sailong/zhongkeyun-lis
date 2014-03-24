<?php 
	CHtml::$afterRequiredLabel = '';
	$form=$this->beginWidget('CActiveForm',array(
		'id'=>'user_form',
		'action' => $this->createUrl('modifyDo'),
		'enableClientValidation'=>true,
		'errorMessageCssClass'=>'red',
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array(
			'class'=>'user_form',
		)
));

echo $form->hiddenField($model,'id'); 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c4">
  <tr>
    <td width="70"><?php echo $form->labelEx($model,'name'); ?>：</td>
    <td>
    	<?php echo $form->textField($model,'name',array('class'=>'validate[required] text-input')); ?>
    </td>
  </tr>
  
  <tr>
    <td width="70"><?php echo $form->labelEx($model,'number'); ?>：</td>
    <td>
    	<?php echo $form->textField($model,'number',array('class'=>'validate[required] text-input')); ?>
    </td>
  </tr>
  
  <tr>
    <td width="70"><?php echo $form->labelEx($model,'expire_date'); ?>：</td>
    <td>
    	<?php echo $form->textField($model,'expire_date',array(
    															'class'=>'validate[required] text-input',
    															'onclick' => 'WdatePicker({readOnly:true})',		
    			)); ?>
    </td>
  </tr>
  
  <tr>
    <td width="70"><?php echo $form->labelEx($model,'producer'); ?>：</td>
    <td><?php echo $form->textArea($model,'producer',array('cols'=>'45','rows'=>5)); ?></td>
  </tr>
 
  <tr>
    <td colspan="2"><input name="保存" type="image" value="保存"src="/images/button5.jpg" />&nbsp;&nbsp;<input name="" type="reset" value="" class="button_in1" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>
</form>
<?php $this->endWidget(); ?>
<script src="/js/My97DatePicker/WdatePicker.js"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#user_form").validationEngine({ 
		scroll:false,
		promptPosition:"centerRight",
		maxErrorsPerField:1,
		showOneMessage:true,
		addPromptClass:"formError-noArrow formError-text"
	});
});
</script>