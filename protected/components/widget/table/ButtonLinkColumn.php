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
class ButtonLinkColumn extends CGridColumn
{
	
	/**
	 * @var string the label for the update button. Defaults to "Update".
	 * Note that the label will not be HTML-encoded when rendering.
	 */
	public $operateButtonLabel1 ;
	
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
	public $operateButtonUrl1 = 'Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))';
	
	
	
	public $operateButtonLabel2;
	
	
	public $operateButtonUrl2 = 'Yii::app()->controller->createUrl("result",array("id"=>$data->primaryKey))';
	
	
	/**
	 * Initializes the column.
	 * This method registers necessary client script for the button column.
	 */
	public function init()
	{
		$this->htmlOptions['class'] = '';
		$this->header = '操作';
		$this->operateButtonLabel1 = '查看详情';
		$this->operateButtonLabel2 = '查看检验结果';
	}

	/**
	 * Renders the data cell content.
	 * This method renders the view, update and delete buttons in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row,$data)
	{
		$url = $this->evaluateExpression($this->operateButtonUrl1,array('data'=>$data, 'row'=>$row));
		echo CHtml::link($this->operateButtonLabel1, $url);
		echo '&nbsp;&nbsp;';
		$url = $this->evaluateExpression($this->operateButtonUrl2,array('data'=>$data, 'row'=>$row));
		echo CHtml::link($this->operateButtonLabel2, $url);
	}
}
