<?php

/**
 * This is the model class for table "quality_control_sample_category".
 *
 * The followings are the available columns in table 'quality_control_sample_category':
 * @property string $id
 * @property string $name
 * @property string $hospital_id
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property QualityControlSample[] $qualityControlSamples
 * @property Hospital $hospital
 */
class QualityControlSampleCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quality_control_sample_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hospital_id, create_time', 'required'),
			array('name', 'length', 'max'=>50),
			array('hospital_id, create_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, hospital_id, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'qualityControlSamples' => array(self::HAS_MANY, 'QualityControlSample', 'category_id'),
			'hospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'hospital_id' => 'Hospital',
			'create_time' => 'Create Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('hospital_id',$this->hospital_id,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QualityControlSampleCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function defaultScope()
	{
		return array(
				'condition'=>" hospital_id = ".Yii::app()->user->hospital_id,
		);
	}
	
	public function getSampleCategoryNameListArray()
	{
		$data = $this->findAll();
		$list = array();
		foreach ($data as $val)
		{
			$list[$val->id] = $val->name;
		}
		return $list;
	}
}
