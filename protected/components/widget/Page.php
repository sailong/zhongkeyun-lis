<?php
class Page extends CBasePager
{
        const CSS_FIRST_PAGE='first';
        const CSS_LAST_PAGE='last';
        const CSS_PREVIOUS_PAGE='previous';
        const CSS_NEXT_PAGE='next';
        const CSS_INTERNAL_PAGE='page';
        const CSS_HIDDEN_PAGE='hidden';
        const CSS_SELECTED_PAGE='selected';

        /**
         * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
         */
        public $maxButtonCount=10;
        /**
         * @var string the text label for the next page button. Defaults to 'Next &gt;'.
         */
        public $nextPageLabel;
        /**
         * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
         */
        public $prevPageLabel;
        /**
         * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
         */
        public $firstPageLabel;
        /**
         * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
         */
        public $lastPageLabel;
        /**
         * @var string the text shown before page buttons. Defaults to 'Go to page: '.
         */
        public $header;
        /**
         * @var string the text shown after page buttons.
         */
        public $footer='';
        /**
         * @var mixed the CSS file used for the widget. Defaults to null, meaning
         * using the default CSS file included together with the widget.
         * If false, no CSS file will be used. Otherwise, the specified CSS file
         * will be included when using this widget.
         */
        public $cssFile;
        /**
         * @var array HTML attributes for the pager container tag.
         */
        public $htmlOptions=array();

        /**
         * Initializes the pager by setting some default property values.
         */
        public function init()
        {
        	if(!isset($this->htmlOptions['class'])) $this->htmlOptions['class']='yema';
        }

        /**
         * Executes the widget.
         * This overrides the parent implementation by displaying the generated page buttons.
         */
        public function run()
        {
               // $this->registerClientScript();
                $buttons=$this->createPageButtons();
                if(empty($buttons))
                        return;
                echo $this->header;
                echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
                echo $this->footer;
        }

        /**
         * Creates the page buttons.
         * @return array a list of page buttons (in HTML code).
         */
        protected function createPageButtons()
        {
                if(($pageCount=$this->getPageCount())<=1)
                        return array();

                list($beginPage,$endPage)=$this->getPageRange();
                $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
                $buttons=array();

                // first page
               //$buttons[]=$this->createPageButton($this->firstPageLabel,0,array(),$currentPage<=0,false);

                // prev page
                if(($page=$currentPage-1)<0)
                        $page=0;
                $buttons[]=$this->createPageButton($this->prevPageLabel,$page,array('class'=>'on'),$currentPage<=0,false);

                // internal pages
                for($i=$beginPage;$i<=$endPage;++$i)
                        $buttons[]=$this->createPageButton($i+1,$i,array(),false,$i==$currentPage);

                // next page
                if(($page=$currentPage+1)>=$pageCount-1)
                        $page=$pageCount-1;
                $buttons[]=$this->createPageButton($this->nextPageLabel,$page,array('class'=>'next'),$currentPage>=$pageCount-1,false);
                return $buttons;
        }

        /**
         * Creates a page button.
         * You may override this method to customize the page buttons.
         * @param string $label the text label for the button
         * @param integer $page the page number
         * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
         * @param boolean $hidden whether this page button is visible
         * @param boolean $selected whether this page button is selected
         * @return string the generated button
         */
        protected function createPageButton($label,$page,$class,$hidden,$selected)
        {
                if( $selected) $class = array('class'=>'cur_ym');
                return CHtml::link($label,$this->createPageUrl($page),is_array($class) ? $class:array());
        }

        /**
         * @return array the begin and end pages that need to be displayed.
         */
        protected function getPageRange()
        {
                $currentPage=$this->getCurrentPage();
                $pageCount=$this->getPageCount();

                $beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));
                if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
                {
                        $endPage=$pageCount-1;
                        $beginPage=max(0,$endPage-$this->maxButtonCount+1);
                }
                return array($beginPage,$endPage);
        }

        /**
         * Registers the needed client scripts (mainly CSS file).
         */
        public function registerClientScript()
        {
                if($this->cssFile!==false)
                        self::registerCssFile($this->cssFile);
        }

        /**
         * Registers the needed CSS file.
         * @param string $url the CSS URL. If null, a default CSS URL will be used.
         */
        public static function registerCssFile($url=null)
        {
                if($url===null)
                        $url=CHtml::asset(Yii::getPathOfAlias('system.web.widgets.pagers.pager').'.css');
                Yii::app()->getClientScript()->registerCssFile($url);
        }
}
