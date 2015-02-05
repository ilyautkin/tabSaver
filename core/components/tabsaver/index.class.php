<?php

/**
 * Class tabSaverMainController
 */
abstract class tabSaverMainController extends modExtraManagerController {
	/** @var tabSaver $tabSaver */
	public $tabSaver;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('tabsaver_core_path', null, $this->modx->getOption('core_path') . 'components/tabsaver/');
		require_once $corePath . 'model/tabsaver/tabsaver.class.php';

		$this->tabSaver = new tabSaver($this->modx);
		$this->addCss($this->tabSaver->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->tabSaver->config['jsUrl'] . 'mgr/tabsaver.js');
		$this->addHtml('
		<script type="text/javascript">
			tabSaver.config = ' . $this->modx->toJSON($this->tabSaver->config) . ';
			tabSaver.config.connector_url = "' . $this->tabSaver->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('tabsaver:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends tabSaverMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}