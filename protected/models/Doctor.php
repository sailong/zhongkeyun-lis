<?php

/**
 * This is the model class for table "doctor".
 *
 * The followings are the available columns in table 'doctor':
 * @property string $id
 * @property string $name
 * @property string $departments_id
 * @property string $hospital_id
 * @property string $mobile
 * @property integer $sex
 * @property string $number
 * @property string $identity_card
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Hospital $hospital
 * @property Departments $departments
 * @property PatientTestRecord[] $patientTestRecords
 */
class Doctor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'doctor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, departments_id, hospital_id, mobile, number, identity_card, create_time', 'required'),
			array('sex', 'numerical', 'integerOnly'=>true),
			array('name, departments_id, hospital_id, number, create_time', 'length', 'max'=>10),
			array('mobile', 'length', 'max'=>11),
			array('identity_card', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, departments_id, hospital_id, mobile, sex, number, identity_card, create_time', 'safe', 'on'=>'search'),
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
			'hospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
			'departments' => array(self::BELONGS_TO, 'Departments', 'departments_id'),
			'patientTestRecords' => array(self::HAS_MANY, 'PatientTestRecord', 'doctor_id'),
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
			'departments_id' => 'Departments',
			'hospital_id' => 'Hospital',
			'mobile' => 'Mobile',
			'sex' => 'Sex',
			'number' => 'Number',
			'identity_card' => 'Identity Card',
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
		$criteria->compare('departments_id',$this->departments_id,true);
		$criteria->compare('hospital_id',$this->hospital_id,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('identity_card',$this->identity_card,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Doctor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
