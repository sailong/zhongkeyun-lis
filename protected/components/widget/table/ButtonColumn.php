<?php
/**
 * CButtonColumn class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.grid.CGridColumn');

/**
 * CButtonColumn represents a grid view column that renders one or several buttons.
 *
 * By default, it will display three buttons, "view", "update" and "delete", which triggers the corresponding
 * actions on the model of the row.
 *
 * By configuring {@link buttons} and {@link template} properties, the column can display other buttons
 * and customize the display order of the buttons.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package zii.widgets.grid
 * @since 1.1
 */
class ButtonColumn extends CGridColumn
{
	
	/**
	 * @var string the label for the update button. Defaults to "Update".
	 * Note that the label will not be HTML-encoded when rendering.
	 */
	public $updateButtonLabel = '';
	/**
	 * @var string the image URL for the update button. If not set, an integrated image will be used.
	 * You may set this property to be false to render a text link instead.
	 */
	public $updateButtonImageUrl;
	/**
	 * @var string a PHP expression that is evaluated for every update button and whose result is used
	 * as the URL for the update button. In this expression, you can use the following variables:
	 * <ul>
	 *   <li><code>$row</code> the row number (zero-based)</li>
	 *   <li><code>$data</code> the data model for the row</li>
	 *   <li><code>$this</code> the column object</li>
	 * </ul>
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 *
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
	 */
	public $updateButtonUrl='Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey))';
	/**
	 * @var array the HTML options for the update button tag.
	 */
	public $updateButtonOptions=array('class'=>'bu_bj');
	
	/**
	 * @var string the label for the delete button. Defaults to "Delete".
	 * Note that the label will not be HTML-encoded when rendering.
	 */
	public $deleteButtonLabel = '';
	/**
	 * @var string the image URL for the delete button. If not set, an integrated image will be used.
	 * You may set this property to be false to render a text link instead.
	 */
	public $deleteButtonImageUrl;
	/**
	 * @var string a PHP expression that is evaluated for every delete button and whose result is used
	 * as the URL for the delete button. In this expression, you can use the following variables:
	 * <ul>
	 *   <li><code>$row</code> the row number (zero-based)</li>
	 *   <li><code>$data</code> the data model for the row</li>
	 *   <li><code>$this</code> the column object</li>
	 * </ul>
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 *
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
	 */
	public $deleteButtonUrl='Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))';
	/**
	 * @var array the HTML options for the delete button tag.
	 */
	public $deleteButtonOptions=array('class'=>'bu_sc');
	/**
	 * @var string the confirmation message to be displayed when delete button is clicked.
	 * By setting this property to be false, no confirmation message will be displayed.
	 * This property is used only if <code>$this->buttons['delete']['click']</code> is not set.
	*/
	public $deleteConfirmation;
	
	
	/**
	 * @var array the configuration for buttons. Each array element specifies a single button
	 * which has the following format:
	 * <pre>
	 * 'buttonID' => array(
	 * 	   'delete'=>false,		// 是否是删除按钮
	 *     'label'=>'...',     // text label of the button
	 *     'url'=>'...',       // a PHP expression for generating the URL of the button
	 *     'imageUrl'=>'...',  // image URL of the button. If not set or false, a text link is used
	 *     'options'=>array(...), // HTML options for the button tag
	 *     'click'=>'...',     // a JS function to be invoked when the button is clicked
	 *     'visible'=>'...',   // a PHP expression for determining whether the button is visible
	 * )
	 * </pre>
	 *
	 * In the PHP expression for the 'url' option and/or 'visible' option, the variable <code>$row</code>
	 * refers to the current row number (zero-based), and <code>$data</code> refers to the data model for
	 * the row.
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
	 *
	 * If the 'buttonID' is 'view', 'update' or 'delete' the options will be applied to the default buttons.
	 *
	 * Note that in order to display non-default buttons, the {@link template} property needs to
	 * be configured so that the corresponding button IDs appear as tokens in the template.
	 */
	public $buttons=array();
	
	/**
	 * 是否显示更新
	 * @var unknown
	 */
	public $update = true;
	
	/**
	 * 是否显示删除
	 * @var unknown
	 */
	public $delete = true;
	
	
	/**
	 * Initializes the column.
	 * This method registers necessary client script for the button column.
	 */
	public function init()
	{
		$this->htmlOptions['class'] = '';
		$this->header = '操作';
		
		if($this->delete)
			$this->registerClientScript();
	}

	/**
	 * 渲染客户端js
	 */
	protected function registerClientScript()
	{
		$script = <<<EOF
jQuery(document).on('click','#{$this->grid->id} a.{$this->deleteButtonOptions['class']}',function(){
	if(window.confirm('确认删除？'))
	{
		var that = jQuery(this);
		jQuery.get(jQuery(this).attr('href'),function(data){
			if(data.status == 1)
				that.closest("tr").remove();
			else
				alert(data.message);
		},'json');
		return false;
	}else{
		return false;	
	}
		
});	
EOF;
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id, $script);
	}
	/**
	 * Renders the data cell content.
	 * This method renders the view, update and delete buttons in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row,$data)
	{
		$tr=array();
		ob_start();
		foreach($this->buttons as $id => $button)
		{
			$this->renderButton($id,$button,$row,$data);
			$tr[]=ob_get_contents();
			ob_clean();
		}
		ob_end_clean();
		echo join('', $tr);
		
		if($this->update)
			$this->renderUpdate($data, $row);
		if($this->delete)
			$this->renderDelete($data, $row);
	}
	
	
	/**
	 * Renders a link button.
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
	 * See {@link buttons} for more details.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data object associated with the row
	 */
	protected function renderButton($id,$button,$row,$data)
	{
		if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data)))
			return;
		$label=isset($button['label']) ? $button['label'] : $id;
		$url=isset($button['url']) ? $this->evaluateExpression($button['url'],array('data'=>$data,'row'=>$row)) : '#';
		$options=isset($button['options']) ? $button['options'] : array();
		if(!isset($options['title']))
			$options['title']=$label;
		if(isset($button['imageUrl']) && is_string($button['imageUrl']))
			echo CHtml::link(CHtml::image($button['imageUrl'],$label),$url,$options);
		else
			echo CHtml::link($label,$url,$options);
	}
	
	
	protected function renderDelete($data, $row)
	{
		$url=$this->evaluateExpression($this->deleteButtonUrl,array('data'=>$data,'row'=>$row));
		echo CHtml::link($this->deleteButtonLabel,$url,$this->deleteButtonOptions);
	}
	
	protected function renderUpdate($data, $row)
	{
		$url=$this->evaluateExpression($this->updateButtonUrl,array('data'=>$data,'row'=>$row));
		echo CHtml::link($this->updateButtonLabel,$url,$this->updateButtonOptions);
	}

}
