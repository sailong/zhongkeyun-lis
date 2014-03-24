<?php

/**
 * This is the model class for table "patient".
 *
 * The followings are the available columns in table 'patient':
 * @property string $id
 * @property string $name
 * @property integer $sex
 * @property string $mobile
 * @property string $identity_card
 * @property string $social_security_card
 * @property string $birthday
 * @property integer $status
 * @property string $extra
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property CustomTestResult[] $customTestResults
 * @property Hospital[] $hospitals
 * @property PatientTestRecord[] $patientTestRecords
 */
class Patient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'patient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sex, mobile, identity_card, social_security_card, birthday, extra, create_time', 'required'),
			array('sex, status', 'numerical', 'integerOnly'=>true),
			array('name, birthday, create_time', 'length', 'max'=>10),
			array('mobile', 'length', 'max'=>11),
			array('identity_card', 'length', 'max'=>18),
			array('social_security_card', 'length', 'max'=>30),
			array('extra', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, sex, mobile, identity_card, social_security_card, birthday, status, extra, create_time', 'safe', 'on'=>'search'),
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
			'customTestResults' => array(self::HAS_MANY, 'CustomTestResult', 'patient_id'),
			'hospitals' => array(self::MANY_MANY, 'Hospital', 'patient_hospital(patient_id, hospital_id)'),
			'patientTestRecords' => array(self::HAS_MANY, 'PatientTestRecord', 'patient_id'),
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
			'sex' => 'Sex',
			'mobile' => 'Mobile',
			'identity_card' => 'Identity Card',
			'social_security_card' => 'Social Security Card',
			'birthday' => 'Birthday',
			'status' => 'Status',
			'extra' => 'Extra',
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
		$criteria->compare('sex',$this->sex);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('identity_card',$this->identity_card,true);
		$criteria->compare('social_security_card',$this->social_security_card,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('extra',$this->extra,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Patient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
