<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var tabSaver $tabSaver */
$tabSaver = $modx->getService('tabsaver', 'tabSaver', $modx->getOption('tabsaver_core_path', null, $modx->getOption('core_path') . 'components/tabsaver/') . 'model/tabsaver/');
$modx->lexicon->load('tabsaver:default');

// handle request
$corePath = $modx->getOption('tabsaver_core_path', null, $modx->getOption('core_path') . 'components/tabsaver/');
$path = $modx->getOption('processorsPath', $tabSaver->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));