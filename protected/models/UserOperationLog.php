<?php

/**
 * This is the model class for table "user_operation_log".
 *
 * The followings are the available columns in table 'user_operation_log':
 * @property string $id
 * @property string $operator_id
 * @property string $operation
 * @property string $object_id
 * @property string $model
 * @property string $create_time
 * @property string $operator
 */
class UserOperationLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_operation_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operator_id, operation, object_id, model, create_time, operator', 'required'),
			array('operator_id, operation, object_id, model, create_time, operator', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, operator_id, operation, object_id, model, create_time, operator', 'safe', 'on'=>'search'),
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
			'operation' => 'Operation',
			'object_id' => 'Object',
			'model' => 'Model',
			'create_time' => 'Create Time',
			'operator' => 'Operator',
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
		$criteria->compare('operation',$this->operation,true);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('operator',$this->operator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserOperationLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
