<?php

/**
 * Create an Item
 */
class tabSaverItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'tabSaverItem';
	public $classKey = 'tabSaverItem';
	public $languageTopics = array('tabsaver');
	//public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$name = trim($this->getProperty('name'));
		if (empty($name)) {
			$this->modx->error->addField('name', $this->modx->lexicon('tabsaver_item_err_name'));
		}
		elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
			$this->modx->error->addField('name', $this->modx->lexicon('tabsaver_item_err_ae'));
		}

		return parent::beforeSet();
	}

}

return 'tabSaverItemCreateProcessor';