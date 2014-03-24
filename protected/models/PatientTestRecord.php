<?php

/**
 * This is the model class for table "patient_test_record".
 *
 * The followings are the available columns in table 'patient_test_record':
 * @property string $id
 * @property string $patient_id
 * @property string $hospital_id
 * @property string $department_id
 * @property string $sample
 * @property string $doctor_id
 * @property string $diagnoses
 * @property string $test_item
 * @property string $device_id
 * @property string $remark
 * @property string $bed_no
 * @property string $operator_id
 * @property string $checker_id
 * @property string $sample_time
 * @property string $test_time
 * @property string $reporting_time
 * @property string $patient_age
 * @property integer $print
 * @property integer $print_time
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property CustomTestResult[] $customTestResults
 * @property Patient $patient
 * @property User $operator
 * @property Doctor $doctor
 * @property Device $device
 * @property PatientTestResult[] $patientTestResults
 */
class PatientTestRecord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'patient_test_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id, hospital_id, department_id, sample, doctor_id, diagnoses, test_item, device_id, remark, bed_no, operator_id, checker_id, sample_time, test_time, reporting_time, create_time', 'required'),
			array('print, print_time', 'numerical', 'integerOnly'=>true),
			array('patient_id, hospital_id, department_id, doctor_id, test_item, device_id, bed_no, operator_id, checker_id, sample_time, test_time, reporting_time, patient_age, create_time', 'length', 'max'=>10),
			array('sample', 'length', 'max'=>20),
			array('diagnoses, remark', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, hospital_id, department_id, sample, doctor_id, diagnoses, test_item, device_id, remark, bed_no, operator_id, checker_id, sample_time, test_time, reporting_time, patient_age, print, print_time, create_time', 'safe', 'on'=>'search'),
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
			'customTestResults' => array(self::HAS_MANY, 'CustomTestResult', 'record_id'),
			'patient' => array(self::BELONGS_TO, 'Patient', 'patient_id'),
			'operator' => array(self::BELONGS_TO, 'User', 'operator_id'),
			'doctor' => array(self::BELONGS_TO, 'Doctor', 'doctor_id'),
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
			'patientTestResults' => array(self::HAS_MANY, 'PatientTestResult', 'record_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'patient_id' => 'Patient',
			'hospital_id' => 'Hospital',
			'department_id' => 'Department',
			'sample' => 'Sample',
			'doctor_id' => 'Doctor',
			'diagnoses' => 'Diagnoses',
			'test_item' => 'Test Item',
			'device_id' => 'Device',
			'remark' => 'Remark',
			'bed_no' => 'Bed No',
			'operator_id' => 'Operator',
			'checker_id' => 'Checker',
			'sample_time' => 'Sample Time',
			'test_time' => 'Test Time',
			'reporting_time' => 'Reporting Time',
			'patient_age' => 'Patient Age',
			'print' => 'Print',
			'print_time' => 'Print Time',
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
		$criteria->compare('patient_id',$this->patient_id,true);
		$criteria->compare('hospital_id',$this->hospital_id,true);
		$criteria->compare('department_id',$this->department_id,true);
		$criteria->compare('sample',$this->sample,true);
		$criteria->compare('doctor_id',$this->doctor_id,true);
		$criteria->compare('diagnoses',$this->diagnoses,true);
		$criteria->compare('test_item',$this->test_item,true);
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('bed_no',$this->bed_no,true);
		$criteria->compare('operator_id',$this->operator_id,true);
		$criteria->compare('checker_id',$this->checker_id,true);
		$criteria->compare('sample_time',$this->sample_time,true);
		$criteria->compare('test_time',$this->test_time,true);
		$criteria->compare('reporting_time',$this->reporting_time,true);
		$criteria->compare('patient_age',$this->patient_age,true);
		$criteria->compare('print',$this->print);
		$criteria->compare('print_time',$this->print_time);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PatientTestRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
