<?php

/**
 * The base class for tabSaver.
 */
class tabSaver {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('tabsaver_core_path', $config, $this->modx->getOption('core_path') . 'components/tabsaver/');
		$assetsUrl = $this->modx->getOption('tabsaver_assets_url', $config, $this->modx->getOption('assets_url') . 'components/tabsaver/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);

		$this->modx->addPackage('tabsaver', $this->config['modelPath']);
		$this->modx->lexicon->load('tabsaver:default');
	}

        /**
         * Запускает процессор из папки zsrehab
         * @param string $action расположение процессора
         * @param array $data данные для передачи в процессор
         * @return $response modResponseObject
         */
        public function runProcessor($action = '', array $data = array()) {
                if (empty($action)) {
                    return false;
                }
                return $this->modx->runProcessor($action, $data, array('processors_path' => $this->config['processorsPath'].'mgr/'));
        }
}