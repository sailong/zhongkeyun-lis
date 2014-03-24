<?php

/**
 * This is the model class for table "quality_control_channel".
 *
 * The followings are the available columns in table 'quality_control_channel':
 * @property string $id
 * @property string $device_id
 * @property string $sample_id
 * @property string $channel
 * @property integer $add_time
 * @property integer $update_time
 *
 * The followings are the available model relations:
 * @property QualityControlSample $sample
 * @property Device $device
 */
class QualityControlChannel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quality_control_channel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, sample_id, channel, add_time', 'required'),
			array('add_time, update_time', 'numerical', 'integerOnly'=>true),
			array('device_id, sample_id, channel', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, device_id, sample_id, channel, add_time, update_time', 'safe', 'on'=>'search'),
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
			'sample' => array(self::BELONGS_TO, 'QualityControlSample', 'sample_id'),
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
			'device_id' => 'Device',
			'sample_id' => 'Sample',
			'channel' => 'Channel',
			'add_time' => 'Add Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('sample_id',$this->sample_id,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QualityControlChannel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
