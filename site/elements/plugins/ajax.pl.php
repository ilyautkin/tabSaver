<?php
if(($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' && !$_REQUEST['action']) || $modx->context->get('key') == "mgr"){return '';}

@ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
$res = array('success' => true, 'message' => '');
if (!$tabSaver = $modx->getService('tabsaver', 'tabSaver', $modx->getOption('tabsaver_core_path', null, $modx->getOption('core_path') . 'components/tabsaver/') . 'model/tabsaver/', array())) {
	return 'Could not load tabSaver class!';
}
switch ($_REQUEST['action']) {
		case 'auth':
			$data = array(
				'username' => $_REQUEST['username']
				,'password' => $_REQUEST['password']
			);    
			$response = $modx->runProcessor('/security/login', $data);
			if ($response->isError()) {
				$res['success'] = false;
				$res['message'] = $response->getMessage();
			} else {
				//print $modx->user->get('username'); die();
				if (!$profile = $modx->user->getOne('Profile')) {
					$profile = $modx->newObject('modUserProfile');
					$profile->addOne($modx->user);
				}
				if (!$_REQUEST['token'] = $profile->get('website')) {
					$_REQUEST['token'] = md5(time().$modx->user->get('username'));
					$profile->set('website', $_REQUEST['token']);
					$profile->save();
				}
				$modx->runProcessor('/security/logout');
			}
    	case 'app':
            $res['version'] = '0.1.33';
			$res['appName'] = 'Offline Pages';
			if ($_REQUEST['token'] && $profile = $modx->getObject('modUserProfile', array('website' => $_REQUEST['token']))) {
				$modx->user = $profile->getOne('User');
				$pages = $modx->runSnippet('pdoResources', array(
						'class'=>'tabSaverTab',
						'loadModels'=>'tabsaver',
						'select'=>'tabSaverTab.*',
						'sortby'=>'{"id":"DESC"}',
						'where'=>'{"uid":'.$modx->user->id.',"deleted":0}',
						'tpl'=>'tpl.tabSaverTab.app'
				));
				$res['start'] = $modx->getChunk('block.styles.app').'
				<ul class="table-view">'.$pages ? $pages : $modx->getChunk('block.empty.list.app').'</ul>';
				$res['start'] = str_replace('src=""','src="'.$modx->getOption('site_url').'tabSaver/site/img/i.png"',$res['start']);
				$res['settings'] = $modx->getChunk('block.styles.app').$modx->getChunk('page.settings.app');
				$res['menu'] = array(
						array(
								'id' => 'start',
								'caption' => 'Страницы',
								'onclick' => 'app.handleMenu(this); $(".appHeader").html("'.$res['appName'].'");'
						),
						array(
								'id' => 'settings',
								'caption' => 'Настройки',
						)
						/*
						array(
								'id' => 'call',
								'caption' => 'Позвонить',
								'class' => 'btn btn-positive btn-block',
								'onclick' => 'app.openURL("tel:'.$res['phone'].'");',
						)
						*/
				);
			} else {
				$res['start'] = $modx->getChunk('page.auth.app');
				$res['menu'] = array(
							array(
									'id' => 'start',
									'caption' => 'Авторизация',
									'onclick' => 'app.handleMenu(this); $(".appHeader").html("'.$res['appName'].'");'
							)
						);
			}
            break;
	case 'addurl':
            $response = $modx->runProcessor('tab/create', array('url' => $_POST['url']), array('processors_path' => $modx->getOption('core_path').'components/tabsaver/processors/mgr/'));
            if (!$response->response['object']) {
                $res['html'] = "";
                $res['success'] = false;
            } else {
                if (!$response->response['object']['img']) $response->response['object']['img'] = "";
                $res['html'] = $modx->getChunk('tpl.tabSaverTab', $response->response['object']);
            }
            break;
        default:
            $res = array('success' => false,'message'=>'Unknown action');
            break;
}
unset($_REQUEST['q']);
unset($_REQUEST['modx_setup_language']);
unset($_REQUEST['PHPSESSID']);
$output = $modx->toJSON(array_merge($_REQUEST,$res));
if (1 == $_REQUEST['debug']) {
$output = '<html><head>'
    . '<style>body { white-space: pre; font-family: monospace; }</style>'
    . '</head><body>'
    . '<script>var obj = '.$output.'; document.body.innerHTML = ""; document.body.appendChild(document.createTextNode(JSON.stringify(obj, null, 4)));</script>'
    . '</body></html>';
}

@session_write_close();
exit($output);