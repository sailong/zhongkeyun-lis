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
	    $alias = $this->getTableAlias(false,false);//$this->getTableAlias(false,false);$this->modelName;
	     
	    return array(
	            'alias' => $alias,
	            'condition' => "status='".self::STATUS_NORMAL."'",
	            'order' => "`$alias`.id DESC"
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
			array('category_id, production_date, release_date, create_time, interface, hospital_id', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, number, category_id, producer, production_date, release_date, standard, remark, create_time, hospital_id', 'safe'),//interface,
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
	
	/**
	 * 批量获取设备统计数据
	 * @param array $device_id_arr
	 */
	public function getDeviceList($device_id_arr,$select=array(),$returnType='object',$byIdRank=false)
	{
	    if(empty($device_id_arr) || !is_array($device_id_arr)) return;
	    $device_id_arr = array_unique($device_id_arr);
	    if(count($device_id_arr) == 1)
	    {
	        $param['condition'] = ' id = '.$device_id_arr[0];
	    }else
	    {
	        $param['condition'] = ' id in ('.implode(',',$device_id_arr).')';
	    }
	    //$param['condition'].=' AND `from` = 1';
	    $select[] = 'id';
	    $param['select'] = implode(',', $select);
	    $result = $this->findAll($param);
	    if(!$result) return;
	    if($byIdRank)
	    {
	        /* //判断是否有头像
	         $hasAvatar = in_array('avatar', $select) ? true : false;
	        //整理顺序
	        $obj = new stdClass();
	        foreach ($result as $val)
	        {
	        $id = $val->id;
	        if($hasAvatar) $val->avatar = $this->getAvatar($val->avatar,$val->id);
	        $obj->$id = $val;
	        }
	        $result = new stdClass();
	        foreach ($uidArr as $id)
	        {
	        $result->$id = $obj->$id;
	        } */
	
	    }
	    if($returnType=='object')
	    {
	        return $result;
	    }else
	    {
	        $data = array();
	        foreach($result as $u)
	        {
	            foreach ($this->attributes as $key=>$val)
	            {
	                if(in_array($key, $select))   $data[$u->id][$key] = $key=='avatar' ? $this->getAvatar($u->avatar,$u->id)  :$u->$key;
	            }
	        }
	        return $data;
	    }
	}
}
