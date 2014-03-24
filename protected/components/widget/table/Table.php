<?php

Yii::import('zii.widgets.grid.CGridView');

class Table extends CGridView
{
	
	
	/**
	 * Initializes the grid view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function init()
	{
		$this->cssFile = false;
		parent::init();
	}
	
	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table class=\"table_box list_t_c\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$this->renderTableHeader();
			ob_start();
			$this->renderTableBody();
			$body=ob_get_clean();
			$this->renderTableFooter();
			echo $body; // TFOOT must appear before TBODY according to the standard.
			echo "</table>";
		}
			else
				$this->renderEmptyText();
	}
	
	/**
	 * Renders the table header(rewrite).
	 */
	public function renderTableHeader()
	{
		if(!$this->hideHeader)
		{
			echo "<thead>\n";
	
			if($this->filterPosition===self::FILTER_POS_HEADER)
				$this->renderFilter();
	
			echo "<tr class=\"bj_g\">\n";
			foreach($this->columns as $column)
			{
				if($column instanceof CDataColumn)
				{
					if($column->name!==null && $column->header===null)
					{
						//if($this->dataProvider->model instanceof CActiveDataProvider)
							echo '<td>'.$this->dataProvider->model->getAttributeLabel($column->name).'</td>';
						//else 
						//	echo CHtml::encode($column->name);
					}else
					{
						echo '<td>'.$column->header.'</td>';
						//echo '<td>' . trim($column->header)!=='' ? $column->header : $column->grid->blankDisplay . '</td>';
					}
				}elseif($column instanceof ButtonColumn) 
					echo '<td>'.$column->header.'</td>';
			}
			echo "</tr>\n";
	
			if($this->filterPosition===self::FILTER_POS_BODY)
				$this->renderFilter();
	
			echo "</thead>\n";
		}
		elseif($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
		{
			echo "<thead>\n";
			$this->renderFilter();
			echo "</thead>\n";
		}
	}

}