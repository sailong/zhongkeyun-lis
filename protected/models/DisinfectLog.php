<?php

/**
 * This is the model class for table "disinfect_log".
 *
 * The followings are the available columns in table 'disinfect_log':
 * @property string $id
 * @property string $operator_id
 * @property integer $disinfect_hours
 * @property integer $time_id
 * @property string $disinfect_day
 * @property string $create_time
 * @property string $hospital_id
 */
class DisinfectLog extends CActiveRecord
{
	public static $dayTimeArr = array(
								1 => '上午',
								2 => '下午'
			);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'disinfect_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operator_id, disinfect_hours, disinfect_day, create_time, hospital_id', 'required'),
			array('disinfect_hours, time_id', 'numerical', 'integerOnly'=>true),
			array('operator_id, disinfect_day, create_time, hospital_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, operator_id, disinfect_hours, time_id, disinfect_day, create_time, hospital_id', 'safe', 'on'=>'search'),
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
			'operator_id' => 'Operator',
			'disinfect_hours' => 'Disinfect Hours',
			'time_id' => 'Time',
			'disinfect_day' => 'Disinfect Day',
			'create_time' => 'Create Time',
			'hospital_id' => 'Hospital',
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
		$criteria->compare('operator_id',$this->operator_id,true);
		$criteria->compare('disinfect_hours',$this->disinfect_hours);
		$criteria->compare('time_id',$this->time_id);
		$criteria->compare('disinfect_day',$this->disinfect_day,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('hospital_id',$this->hospital_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DisinfectLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * 判断是否登记签到
	 * 	 */
	public function checkHasSign($operator_id,$day_uninx_time,$time_id)
	{
		return $this->findAllByAttributes(array(
												'operator_id' => $operator_id,
												'time_id' => $time_id,
												'disinfect_day' => $day_uninx_time
				));
	}
}
