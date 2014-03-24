<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $name
 * @property string $number
 * @property string $mobile
 * @property string $password
 * @property string $identification
 * @property string $hospital_id
 * @property integer $is_superuser
 * @property integer $create_time
 * @property string $last_login
 * @property string $department_id
 * @property integer $sex
 *
 * The followings are the available model relations:
 * @property PatientTestRecord[] $patientTestRecords
 * @property Hospital $hospital
 * @property Departments $department
 */
class User extends CActiveRecord
{
	/**
	 * 用户状态 1正常 0已删除
	 * @var unknown
	 */
	const STATUS_DELETE = 0;
	
	const STATUS_NORMAL = 1;
	
	public $verifyPassword = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
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
			array('name, number, mobile, password, verifyPassword', 'required'),
			array('name, number, hospital_id, last_login, department_id', 'length', 'max'=>10),
			array('mobile', 'length', 'max'=>11),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => '两次输入密码不一致'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, number, mobile, password, hospital_id, is_superuser, create_time, last_login, department_id, sex', 'safe', 'on'=>'search'),
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
			'patientTestRecords' => array(self::HAS_MANY, 'PatientTestRecord', 'operator_id'),
			'hospital' => array(self::BELONGS_TO, 'Hospital', 'hospital_id'),
			'department' => array(self::BELONGS_TO, 'Departments', 'department_id'),
			'role' => array(self::HAS_ONE, 'AuthAssignment', 'userid', 'with'=>'item')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '姓名',
			'number' => '编号',
			'mobile' => '手机',
			'password' => 'Password',
			'hospital_id' => 'Hospital',
			'is_superuser' => 'Is Superuser',
			'create_time' => 'Create Time',
			'last_login' => 'Last Login',
			'department_id' => '部门',
			'sex' => '性别',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('mobile',$this->mobile,true);
		
		// 关联角色表
		$criteria->join = 'join authassignment as aa on aa.userid=id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 批量获取用户数据
	 * @param array $uidArr   array(1,2,3,4)
	 * @param array $select   array('id','name')
	 * @return array();
	 */
	public function getUserDataBatch($uidArr,$select = array())
	{
		if(empty($uidArr) || !is_array($uidArr)) return array();
		$uidArr = array_unique($uidArr);
		if(count($uidArr) == 1)
		{
			$param['condition'] = ' id = '.reset($uidArr);
		}else
		{
			$param['condition'] = ' id in ('.implode(',',$uidArr).')';
		}
		if($select) 
		{
			array_push($select, 'id');
			$select = array_unique($select);
			$param['select'] = implode(',', $select);
		}
		$user = $this->findAll($param);
		if(!$user) return array();
		$userInfo = array();
		foreach($user as $u)
		{
			$tempData = array();
			if($select)
			{
				foreach ($this->attributes as $key=>$val)
				{
					if(in_array($key, $select))   $tempData[$key] = $u->$key;
				}
			}else
			{
				$tempData = $u->attributes;
			}	
			$userInfo[$u->id] = $tempData;
		}
		return $userInfo;
	}
	
	
	/**
	 * 根据用户id获取用户角色
	 * @param unknown $uid
	 */
	public function getRole($uid)
	{
		$data = AuthAssignment::model()->with('itemname')->findByAttributes(array('userid'=>$uid));
		
		
		
		
	}
	
}
