<?php

/**
 * This is the model class for table "custom_test_result".
 *
 * The followings are the available columns in table 'custom_test_result':
 * @property string $id
 * @property string $record_id
 * @property string $patient_id
 * @property string $category_id
 * @property string $name
 * @property string $value
 * @property string $create_time
 * @property string $extra
 *
 * The followings are the available model relations:
 * @property Patient $patient
 * @property PatientTestRecord $record
 */
class CustomTestResult extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'custom_test_result';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_id, patient_id, category_id, name, value, create_time', 'required'),
			array('record_id, patient_id, category_id, create_time', 'length', 'max'=>10),
			array('name, value', 'length', 'max'=>20),
			array('extra', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, record_id, patient_id, category_id, name, value, create_time, extra', 'safe', 'on'=>'search'),
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
			'patient' => array(self::BELONGS_TO, 'Patient', 'patient_id'),
			'record' => array(self::BELONGS_TO, 'PatientTestRecord', 'record_id'),
			'parameter' => array(self::BELONGS_TO, 'CustomTestItem', 'parameter_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'record_id' => 'Record',
			'patient_id' => 'Patient',
			'category_id' => 'Category',
			'name' => 'Name',
			'value' => 'Value',
			'create_time' => 'Create Time',
			'extra' => 'Extra',
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
		$criteria->compare('record_id',$this->record_id,true);
		$criteria->compare('patient_id',$this->patient_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('extra',$this->extra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomTestResult the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
