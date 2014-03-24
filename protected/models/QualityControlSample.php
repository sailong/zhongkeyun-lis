<?php

/**
 * This is the model class for table "quality_control_sample".
 *
 * The followings are the available columns in table 'quality_control_sample':
 * @property string $id
 * @property string $name
 * @property string $number
 * @property string $hospital_id
 * @property string $expire_date
 * @property string $producer
 * @property string $create_time
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property QualityControlChannel[] $qualityControlChannels
 */
class QualityControlSample extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quality_control_sample';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, number, hospital_id, expire_date, producer, create_time', 'required'),
			array('name', 'length', 'max'=>5),
			array('number, producer', 'length', 'max'=>20),
			array('hospital_id, expire_date, create_time, alias', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, number, hospital_id, expire_date, producer, create_time, alias', 'safe', 'on'=>'search'),
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
			'qualityControlChannels' => array(self::HAS_MANY, 'QualityControlChannel', 'sample_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '名称',
			'number' => '批号',
			'hospital_id' => 'Hospital',
			'expire_date' => '有效期',
			'producer' => '生产厂家',
			'create_time' => 'Create Time',
			'alias' => 'Alias',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('hospital_id',$this->hospital_id,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('producer',$this->producer,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QualityControlSample the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave()
	{
		$this->expire_date = strtotime($this->expire_date);
		if($this->isNewRecord)
		{
			$this->hospital_id = Yii::app()->user->hospital_id;
			$this->create_time = time();
		}
		return true;
		
	}
}
