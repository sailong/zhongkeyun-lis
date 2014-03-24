<?php
class SearchForm extends CFormModel
{
   
    public $keyword;

    public function rules()
    {
        return array(
            array('keyword', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'keyword'=>'keyword'
        );
    }
}
