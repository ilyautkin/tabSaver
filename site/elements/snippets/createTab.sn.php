<?php
@ini_set('display_errors',1);
/** @var array $scriptProperties */
/** @var tabSaver $tabSaver */
if (!$tabSaver = $modx->getService('tabsaver', 'tabSaver', $modx->getOption('tabsaver_core_path', null, $modx->getOption('core_path') . 'components/tabsaver/') . 'model/tabsaver/', array())) {
	return 'Could not load tabSaver class!';
}

/*
$response = $modx->runProcessor('tab/create', array('url' => 'http://lenta.ru/news/2015/02/05/prsdntsalary/'), array('processors_path' => $modx->getOption('core_path').'components/tabsaver/processors/mgr/'));
print '<pre>';
print_r($response->response);
print '</pre>';

*/