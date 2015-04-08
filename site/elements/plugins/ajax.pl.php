<?php
if(($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' && !$_REQUEST['action']) || $modx->context->get('key') == "mgr"){return '';}
//if (){return '';}
header('Access-Control-Allow-Origin: *');
$res = array('success' => true, 'message' => '');
if (!$tabSaver = $modx->getService('tabsaver', 'tabSaver', $modx->getOption('tabsaver_core_path', null, $modx->getOption('core_path') . 'components/tabsaver/') . 'model/tabsaver/', array())) {
	return 'Could not load tabSaver class!';
}
switch ($_REQUEST['action']) {
    	case 'app':
            $res['version'] = '0.1.29';
    	    if (isset($_REQUEST['version']) && $_REQUEST['version'] && $_REQUEST['version'] == $res['version']) {
    	        $res['code'] = 304;
    	        $res['message'] = '304 Not modified';
    	    } else {
                $res['appName'] = 'Offline Pages';
                $res['phone'] = '+70000000000';
                $res['start'] = '<style>
                        .content-padded {
                            margin-left: 0;
                            margin-right: 0;
                            padding-left: 10px;
                            padding-right: 10px;
                        }
                        .table-view .media-object.pull-left {
                            margin-top: 4px;
                        }
                     </style>
                     <ul class="table-view" style="margin: -13px -15px -25px;">'.$modx->runSnippet('pdoResources', array(
                        'class'=>'tabSaverTab',
                        'loadModels'=>'tabsaver',
                        'select'=>'tabSaverTab.*',
                        'sortby'=>'{"id":"DESC"}',
                        'where'=>'{"uid":'.$modx->user->id.',"deleted":0}',
                        'tpl'=>'tpl.tabSaverTab.app'
                )).'</ul>';
                $res['start'] = str_replace('src=""','src="'.$modx->getOption('site_url').'tabSaver/site/img/i.png"',$res['start']);
                $res['pages'] = $res['start'];
                $res['settings'] = '';
                $res['menu'] = array(
                                array(
                                        'id' => 'pages',
                                        'caption' => 'Страницы',
                                        'onclick' => 'app.handleMenu(this); $(".appHeader").html("'.$res['appName'].'");'
                                ),
                                array(
                                        'id' => 'settings',
                                        'caption' => 'Настройки',
                                ),
                                /*
                                array(
                                        'id' => 'call',
                                        'caption' => 'Позвонить',
                                        'class' => 'btn btn-positive btn-block',
                                        'onclick' => 'app.openURL("tel:'.$res['phone'].'");',
                                )
                                */
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
        case 'delete':
            $res['success'] = true;
            //print_r($modx->fromJSON($_POST['todelete']));
            //die();
            @ini_set('display_errors',1);
            $todelete = $modx->fromJSON($_POST['todelete']);
            if ($todelete && is_array($todelete)) {
                foreach($todelete as $id) {
                    $tab = $modx->getObject('tabSaverTab', $id);
                    $tab->set('deleted', 1);
                    if (!$tab->save()) {
                        $res['success'] = false;
                        $res['todelete'][] = $id;
                    }
                }
            } else {
                $res['success'] = false;
                $res['message'] = 'Wrong list to delete';
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