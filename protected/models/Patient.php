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
	 * 年龄,数据库没有此字段
	 * @var unknown
	 */
	public $age = NULL;
	
	/**
	 * 性别 1女 2男
	 * @var unknown
	 */
	const SEX_FEMAL = 1;
	const SEX_MALE = 2;
	
	/**
	 * 用户状态 1正常 0已删除
	 * @var unknown
	 */
	const STATUS_DELETE = 0;
	
	const STATUS_NORMAL = 1;
	
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
			array('create_time','default','value'=>time()),
			array('name, sex, mobile, identity_card, social_security_card, birthday', 'required'),
			array('sex', 'numerical', 'integerOnly'=>true),
			array('name, birthday, create_time', 'length', 'max'=>10),
			array('mobile', 'length', 'max'=>11),
			array('identity_card', 'unique'),
			array('social_security_card', 'unique'),
			array('identity_card', 'length', 'max'=>18),
			array('social_security_card', 'length', 'max'=>30),
			array('extra', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, sex, mobile, identity_card, social_security_card, birthday, address, extra, create_time', 'safe', 'on'=>'search'),
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

	public function defaultScope()
	{
		return array(
			'condition' => $this->getTableAlias(false,false).".status='".self::STATUS_NORMAL."'",
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '序号',
			'name' => '姓名',
			'sex' => '性别',
			'birthday' => '出生日期',
			'mobile' => '手机号码',
			'identity_card' => '身份证',
			'social_security_card' => '社保卡',
			'status' => 'Status',
			'extra' => 'Extra',
			'create_time' => 'Create Time',
			'address' => '地址'
			
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
		
		$criteria->order = 'id desc';
		
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
