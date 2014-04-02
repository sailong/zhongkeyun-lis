<?php

/**
 * This is the model class for table "record_print_log".
 *
 * The followings are the available columns in table 'record_print_log':
 * @property string $id
 * @property string $record_id
 * @property integer $type
 * @property string $operator_id
 * @property integer $status
 * @property string $extra
 * @property string $create_time
 */
class RecordPrintLog extends CActiveRecord
{
	/**
	 * 日志记录类型,1是病人检测结果打印2质控打印
	 * @var unknown
	 */
	const TYPE_PATIENT_TEST_RECORD = 1;
	const TYPE_CONTROL_TEST_RECORD = 2;
	
	
	/**
	 * 打印进行状态0开始打印不知道能否打印成功 1 打印完成
	 * @var unknown
	 */
	const PRINT_STATUS_BEGIN = 0;
	const PRINT_STATUS_OVER = 1;
	
	
	/**
	 * 打印所在位置
	 * @var unknown
	 */
	public static $position = array(
		self::TYPE_PATIENT_TEST_RECORD => array(
				'CHECK' => 1,  // 检测页面打印
				'RESULT' => 2  // 结果页面打印
		),
		
	);
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'record_print_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_id, operator_id, create_time', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, record_id, type, operator_id, status, position, create_time, print_time', 'safe'),
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
			'record_id' => 'Record',
			'type' => 'Type',
			'operator_id' => 'Operator',
			'status' => 'Status',
			'extra' => 'Extra',
			'create_time' => 'Create Time',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecordPrintLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
