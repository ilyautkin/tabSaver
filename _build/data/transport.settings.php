<?php

$settings = array();

$tmp = array(
	'rca_key' => array(
		'xtype' => 'textfield',
		'value' => '',
		'area' => 'tabsaver_main',
	),
);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'tabsaver_' . $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
