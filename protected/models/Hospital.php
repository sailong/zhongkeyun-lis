<?php

/**
 * This is the model class for table "hospital".
 *
 * The followings are the available columns in table 'hospital':
 * @property string $id
 * @property string $name
 * @property string $intro
 * @property string $address
 * @property integer $add_time
 *
 * The followings are the available model relations:
 * @property Category[] $categories
 * @property Device[] $devices
 * @property Doctor[] $doctors
 * @property Patient[] $patients
 * @property User[] $users
 */
class Hospital extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hospital';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, add_time', 'required'),
			array('add_time', 'numerical', 'integerOnly'=>true),
			array('name, intro, address', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, intro, address, add_time', 'safe', 'on'=>'search'),
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
			'categories' => array(self::HAS_MANY, 'Category', 'hospital_id'),
			'devices' => array(self::HAS_MANY, 'Device', 'hospital_id'),
			'doctors' => array(self::HAS_MANY, 'Doctor', 'hospital_id'),
			'patients' => array(self::MANY_MANY, 'Patient', 'patient_hospital(hospital_id, patient_id)'),
			'users' => array(self::HAS_MANY, 'User', 'hospital_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'intro' => 'Intro',
			'address' => 'Address',
			'add_time' => 'Add Time',
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
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('add_time',$this->add_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hospital the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 批量获取医院统计数据
	 * @param array $hospital_id_arr
	 */
	public function getHospitalList($hospital_id_arr,$select=array(),$returnType='object',$byIdRank=false)
	{
	    if(empty($hospital_id_arr) || !is_array($hospital_id_arr)) return;
	    $hospital_id_arr = array_unique($hospital_id_arr);
	    if(count($hospital_id_arr) == 1)
	    {
	        $param['condition'] = ' id = '.$hospital_id_arr[0];
	    }else
	    {
	        $param['condition'] = ' id in ('.implode(',',$hospital_id_arr).')';
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
