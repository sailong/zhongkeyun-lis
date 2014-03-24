<?php

/**
 * This is the model class for table "quality_control_record".
 *
 * The followings are the available columns in table 'quality_control_record':
 * @property string $id
 * @property string $device_id
 * @property string $channel_id
 * @property integer $print
 * @property string $create_time
 * @property string $print_time
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Device $device
 * @property QualityControlResult[] $qualityControlResults
 */
class QualityControlRecord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quality_control_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, channel_id, create_time, date', 'required'),
			array('print', 'numerical', 'integerOnly'=>true),
			array('device_id, channel_id, print_time, date', 'length', 'max'=>10),
			array('create_time', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, device_id, channel_id, print, create_time, print_time, date', 'safe', 'on'=>'search'),
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
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
			'qualityControlResults' => array(self::HAS_MANY, 'QualityControlResult', 'record_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'device_id' => 'Device',
			'channel_id' => 'Channel',
			'print' => 'Print',
			'create_time' => 'Create Time',
			'print_time' => 'Print Time',
			'date' => 'Date',
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
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('channel_id',$this->channel_id,true);
		$criteria->compare('print',$this->print);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('print_time',$this->print_time,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QualityControlRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
