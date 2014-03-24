<?php

/**
 * This is the model class for table "quality_control_result".
 *
 * The followings are the available columns in table 'quality_control_result':
 * @property string $id
 * @property string $record_id
 * @property string $device_id
 * @property string $code
 * @property string $value
 * @property string $extra
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property QualityControlRecord $record
 * @property Device $device
 */
class QualityControlResult extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quality_control_result';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_id, device_id, code, value, create_time', 'required'),
			array('record_id, device_id, create_time', 'length', 'max'=>10),
			array('code, value', 'length', 'max'=>20),
			array('extra', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, record_id, device_id, code, value, extra, create_time', 'safe', 'on'=>'search'),
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
			'record' => array(self::BELONGS_TO, 'QualityControlRecord', 'record_id'),
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
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
			'device_id' => 'Device',
			'code' => 'Code',
			'value' => 'Value',
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
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('value',$this->value,true);
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
	 * @return QualityControlResult the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
