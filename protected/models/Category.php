<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $create_time
 * @property integer $automatic
 * @property string $hospital_id
 *
 * The followings are the available model relations:
 * @property Hospital $hospital
 * @property CustomTestItem[] $customTestItems
 * @property Device[] $devices
 */
class Category extends CActiveRecord
{
    
    
    /**
	 * 分类是否删除,0删除,1不删除
	 * @var unknown
	 */
	const STATUS_DELETE = 0;
	const STATUS_NORMAL = 1;
    
	/**
	 * 是否机器检测1是 0不是
	 * @var unknown
	 */
	const AUTOMATIC_YES = 1;
	const AUTOMATIC_NO = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}
	
	
	public function defaultScope()
	{
	    return array(
            'condition' => $this->getTableAlias(false,false) . ".status='".self::STATUS_NORMAL."'",
	    );
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
			array('hospital_id','default','value'=>Yii::app()->user->hospital_id),
			array('name, create_time, hospital_id', 'required'),
			array('name, create_time, hospital_id', 'length', 'max'=>20),
			array('name', 'unique',  'message'=>'该分类已经存在了！'),
			array('description', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, status, create_time, automatic, hospital_id', 'safe','on'=>'search'),
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
			'hospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
			'customTestItems' => array(self::HAS_MANY, 'CustomTestItem', 'category_id'),
			'devices' => array(self::HAS_MANY, 'Device', 'category_id'),
	        'patientTestRecords' => array(self::HAS_MANY, 'PatientTestRecord', 'category_id'),
	        'qualityControlChannels' => array(self::HAS_MANY, 'QualityControlChannel', 'category_id'),
	        'qualityControlRecords' => array(self::HAS_MANY, 'QualityControlRecord', 'category_id'),
	        'qualityControlResults' => array(self::HAS_MANY, 'QualityControlResult', 'category_id'),
		);
	}
	
	public function scopes()
	{
		return array(
			'custom' => array(
				'condition' => 'automatic ='.self::AUTOMATIC_NO
			)
		);
		
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '分类名称',
			'description' => '描述',
			'status' => '删除状态',
			'create_time' => '添加时间',
			'automatic' => '是否机器检测',
			'hospital_id' => '医院名称',
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
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
