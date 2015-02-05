<?php

/**
 * Remove an Items
 */
class tabSaverItemRemoveProcessor extends modObjectProcessor {
	public $objectType = 'tabSaverItem';
	public $classKey = 'tabSaverItem';
	public $languageTopics = array('tabsaver');
	//public $permission = 'remove';


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
			/** @var tabSaverItem $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('tabsaver_item_err_nf'));
			}

			$object->remove();
		}

		return $this->success();
	}

}

return 'tabSaverItemRemoveProcessor';