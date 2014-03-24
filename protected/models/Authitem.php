<?php

/**
 * This is the model class for table "authitem".
 *
 * The followings are the available columns in table 'authitem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Authassignment[] $authassignments
 * @property Authitemchild[] $authitemchildren
 * @property Authitemchild[] $authitemchildren1
 */
class Authitem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'authitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			//array('name', 'regularExpression', 'pattern'=>'[a-zA-z]'),
			array('name', 'length', 'max'=>64),
			array('name','unique'),
			array('description, bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, type, description, bizrule, data,remark,hospital_id', 'safe', 'on'=>'search'),
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
			'authassignments' => array(self::HAS_MANY, 'Authassignment', 'itemname'),
			'authitemchildren' => array(self::HAS_MANY, 'Authitemchild', 'parent'),
			'authitemchildren1' => array(self::HAS_MANY, 'Authitemchild', 'child'),
		);
	}
	
	public function scopes()
	{
		
		return array(
			'roles' => array(
				'condition' => '`type`='.CAuthItem::TYPE_ROLE.' and hospital_id='.Yii::app()->user->hospital_id.'',
			)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Name',
			'type' => 'Type',
			'description' => '名称',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
			'remark'=>'备注'
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
		$criteria->compare('description',$this->description,true);

		$criteria->scopes = 'roles';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Authitem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * 创建角色
	 */
	public function createRoles($param=array())
	{
		
		$auth=Yii::app()->authManager;
		$role = $auth->createRole($param['name'],$param['description'],NULL,NULL,$param['remark']);
		foreach ($param['access'] as $access)
		{
			$role->addChild($access);
		}
		return true;
	}
	
}
