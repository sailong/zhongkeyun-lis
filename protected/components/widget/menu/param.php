<?php
/**
 * 左侧导航菜单
 */
return array(
	array(
		'title' => '报告单管理',
		'children' => array(
			array(
				'title' => '项目检测',
				'class' => 'l1',
				'id' => '/site/test'
			),
			array(
				'title' => '报告单记录',
				'class' => 'l2',
				'id' => '/controllerId/actionId'
			),
			array(
				'title' => '自定义报告单',
				'class' => 'l4',
				'id' => '/controllerId/actionId'
			),
		)
	),
	array(
		'title' => '检测项目管理',
		'children' => array(
			array(
				'title' => '项目分类',
				'class' => 'l6',
				'id' => '/category/index'
			),
			array(
				'title' => '自定义项目参数',
				'class' => 'l3',
				'id' => '/parameter/index'
			)
		)
	),
	array(
		'title' => '质控管理',
		'children' => array(
			array(
				'title' => '质控项目',
				'class' => 'l6',
				'id' => '/controllerId/actionId'
			),
			array(
				'title' => '质控品',
				'class' => 'l7',
				'id' => '/QualityControlSample/index'
			),
			array(
				'title' => '绘制质控图',
				'class' => 'l13',
				'id' => '/controllerId/actionId'
			),
			array(
				'title' => '通道设置',
				'class' => 'l4',
				'id' => '/QualityControlChannel/index'
			),
		)
	),
	array(
		'title' => '权限管理',
		'children' => array(
			array(
				'title' => '人员管理',
				'class' => 'l9',
				'id' => '/operator/index'
			),
			array(
				'title' => '权限管理',
				'class' => 'l10',
				'id' => '/access/index'
			),
		)
	),
	array(
		'title' => '数据统计',
		'children' => array(
			array(
				'title' => '紫外线消毒统计',
				'class' => 'l11',
				'id' => '/disinfect'
			),
		)
	),
	array(
		'title' => '设备管理',
		'children' => array(
			array(
				'title' => '设备清单',
				'class' => 'l15',
				'id' => '/device/index'
			),
		)
	),
	array(
		'title' => '患者管理',
		'children' => array(
			array(
				'title' => '患者列表',
				'class' => 'l12',
				'id' => '/controllerId/actionId'
			),
		)
	),
	
);