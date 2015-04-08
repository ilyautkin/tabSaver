<?php

/**
 * Enable an Item
 */
class tabSaverTabEnableProcessor extends modObjectProcessor {
	public $objectType = 'tabSaverTab';
	public $classKey = 'tabSaverTab';
	public $languageTopics = array('tabsaver');
	//public $permission = 'save';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('tabsaver_item_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var tabSaverTab $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('tabsaver_item_err_nf'));
			}

			$object->set('deleted', false);
			$object->save();
		}

		return $this->success();
	}

}

return 'tabSaverTabEnableProcessor';
