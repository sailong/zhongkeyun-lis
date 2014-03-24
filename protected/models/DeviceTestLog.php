<?php

/**
 * This is the model class for table "device_test_log".
 *
 * The followings are the available columns in table 'device_test_log':
 * @property string $id
 * @property string $record_id
 * @property integer $type
 * @property string $operator_id
 * @property string $device_id
 * @property integer $status
 * @property string $extra
 * @property string $create_time
 */
class DeviceTestLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device_test_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_id, operator_id, device_id, create_time', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('record_id, operator_id, device_id, create_time', 'length', 'max'=>10),
			array('extra', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, record_id, type, operator_id, device_id, status, extra, create_time', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'operator_id' => 'Operator',
			'device_id' => 'Device',
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
		$criteria->compare('record_id',$this->record_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('operator_id',$this->operator_id,true);
		$criteria->compare('device_id',$this->device_id,true);
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
	 * @return DeviceTestLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
