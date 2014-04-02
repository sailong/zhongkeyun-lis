<div class="search-form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<?php echo $form->dropDownList($model,'category_id',$sampleCategory,array('empty'=>'--请选择--')); ?>
	<input type="image" src="/images/button7.jpg" />&nbsp;&nbsp;
	<a href="<?php echo $this->createUrl('modify');?>"><img src="/images/button8.jpg" /></a>
<?php $this->endWidget(); ?>
</div>
<?php $this->widget('application.components.widget.Tips',array('name'=>'QualityControlSample'));?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_box list_t_c">
  <tr class="bj_g">
    <td>ID</td>
    <td>名称</td>
    <td>批号</td>
    <td>产品有效期</td>
    <td>生产厂家</td>
    <td>操作</td>
  </tr>
  <?php
		$data = $dataProvider->getData();
		foreach ($data as $val)
		{
  ?>
  <tr id="tr_<?php echo $val->id;?>">
    <td><?php echo $val->id;?></td>
    <td><?php echo isset($sampleCategory[$val->category_id]) ? $sampleCategory[$val->category_id]:'';?></td>
    <td><?php echo $val->number;?></td>
    <td><?php echo date('Y-m-d',$val->expire_date);?></td>
    <td><?php echo $val->producer;?></td>
    <td><a href="<?php echo $this->createUrl('modify',array('id'=>$val->id));?>" class="bu_bj"></a><a href="javascript:;" class="bu_sc" data_id="<?php echo $val->id;?>" url="<?php echo $this->createUrl('delete',array('id'=>$val->id));?>"></a>
    </td>
  </tr>
  <?php }?>
</table>
<?php 
    $this->widget('application.components.widget.Page',array( 'pages' => $dataProvider->getPagination()));   
?> 
<script type="text/javascript" src="/js/common.js"></script>