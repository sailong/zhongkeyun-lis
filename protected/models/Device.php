<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property string $id
 * @property string $name
 * @property string $number
 * @property string $category_id
 * @property string $producer
 * @property string $production_date
 * @property string $release_date
 * @property string $standard
 * @property string $remark
 * @property string $create_time
 * @property string $interface
 * @property integer $delete
 * @property string $hospital_id
 *
 * The followings are the available model relations:
 * @property CustomTestItem[] $customTestItems
 * @property Hospital $hospital
 * @property Category $category
 * @property PatientTestRecord[] $patientTestRecords
 * @property QualityControlChannel[] $qualityControlChannels
 * @property QualityControlRecord[] $qualityControlRecords
 * @property QualityControlResult[] $qualityControlResults
 */
class Device extends CActiveRecord
{
    
    /**
     * 设备状态,0删除,1正常,2弃用
     * STATUS_DELETE 0 删除
     * STATUS_NORMAL 1 正常
     * STATUS_DISCARD 2 弃用
     * @var unknown
     */
    const STATUS_DELETE = 0; //删除
    const STATUS_NORMAL = 1; //正常
    const STATUS_DISCARD = 2;//弃用
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device';
	}
	
	public function defaultScope()
	{
	    return array(
            'condition' =>  $this->getTableAlias(false,false) . ".status='".self::STATUS_NORMAL."'",
            'order' => $this->getTableAlias(false,false) . ".id DESC"
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
			array('name, number, category_id, producer, production_date, release_date, standard, create_time, hospital_id', 'required'),//interface,
			array('name, number, producer, standard', 'length', 'max'=>20),
			array('number', 'checkExist', 'message'=>'该设备型号已存在'),
			array('production_date', 'compare', 'compareValue' => strtotime(date('Y-m-d',time())), 'operator'=>'<', 'message'=>'生产日期需小于当前日期'),
			array('release_date', 'compare', 'compareAttribute' => 'production_date', 'operator'=>'>', 'message' => '出厂日期应大于生产日期'),
			array('remark', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, number, category_id, producer, production_date, release_date, standard, remark, create_time, hospital_id', 'safe'),//interface,
		);
	}

	/**
	 * 检测设备编号是否已经存在
	 * @param unknown $attribute
	 * @param unknown $param
	 * @return boolean
	 */
	public function checkExist($attribute, $param)
	{
		$all = $this->findAllByAttributes(array($attribute=>$this->{$attribute},'hospital_id'=>Yii::app()->user->hospital_id));
		$total = count($all);
		if($total == 0)
			return true;
		elseif(!$this->isNewRecord && ($total == 1) && ($all[0]->id == $this->id))
		return true;
		else
			$this->addError($attribute, $param['message']);
		
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customTestItems' => array(self::HAS_MANY, 'CustomTestItem', 'device_id'),
			'hospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'patientTestRecords' => array(self::HAS_MANY, 'PatientTestRecord', 'device_id'),
			'qualityControlChannels' => array(self::HAS_MANY, 'QualityControlChannel', 'device_id'),
			'qualityControlRecords' => array(self::HAS_MANY, 'QualityControlRecord', 'device_id'),
			'qualityControlResults' => array(self::HAS_MANY, 'QualityControlResult', 'device_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '序号',
			'name' => '设备名称',
			'number' => '型号',
			'category_id' => '类别',
			'producer' => '厂家',
			'production_date' => '生产日期',
			'release_date' => '出厂日期',
			'standard' => '规格',
			'remark' => '备注',
			'create_time' => '创建时间',
			'interface' => '接口标志',
			'status' => '是否弃用',
			'hospital_id' => '医院',
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
		//$criteria->compare('number',$this->number,true);
		//$criteria->compare('producer',$this->producer,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
