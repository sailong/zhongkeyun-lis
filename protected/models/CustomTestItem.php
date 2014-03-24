<?php

/**
 * This is the model class for table "custom_test_item".
 *
 * The followings are the available columns in table 'custom_test_item':
 * @property string $id
 * @property string $category_id
 * @property string $device_id
 * @property string $name
 * @property string $code
 * @property string $unit
 * @property string $ref_start
 * @property string $description
 * @property string $create_time
 * @property integer $delete
 * @property string $ref_end
 * @property string $range
 *
 * The followings are the available model relations:
 * @property Device $device
 * @property Category $category
 */
class CustomTestItem extends CActiveRecord
{
	
	/**
	 * 状态1 正常 0已删除
	 * @var unknown
	 */
	const STATUS_NORMAL = 1;
	const STATUS_DELETE = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'custom_test_item';
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
			array('category_id, device_id, name, code, unit, range', 'required'),
			array('name, code, unit, ref_start, ref_end', 'length', 'max'=>10),
			array('remark, range', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, code, description, ref_end, range', 'safe', 'on'=>'search'),
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::defaultScope()
	 */
	public function defaultScope()
	{
		return array(
			'alias' => 'cti',
			'condition' => "status='".self::STATUS_NORMAL."'",
			'order' => "cti.id DESC"
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '编号',
			'category_id' => '分类',
			'device_id' => '设备',
			'name' => '名称',
			'code' => '代号',
			'unit' => '单位',
			'ref_start' => '参考值start',
			'description' => '描述',
			'create_time' => '创建时间',
			'status' => '是否删除',
			'ref_end' => '参考值end',
			'range' => '结果范围',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('unit',$this->unit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomTestItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
