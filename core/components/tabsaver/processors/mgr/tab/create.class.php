<?php

/**
 * Create an Item
 */
class tabSaverItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'TabsaverTab';
	public $classKey = 'TabsaverTab';
	public $languageTopics = array('tabsaver');
        //public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
                $uid = $this->modx->user->id;
                if ($uid) {
                    $this->setProperty('uid', $uid);
                } else {
                    $this->modx->error->addField('uid', $this->modx->lexicon('tabsaver_item_err_uid'));
                    return false;
                }
		$url = trim($this->getProperty('url'));
		if (empty($url)) {
                    $this->modx->error->addField('url', $this->modx->lexicon('tabsaver_item_err_url'));
                    return false;
		}
		elseif ($dublicate = $this->modx->getObject($this->classKey, array('url' => $url, 'uid' => $uid))) {
                    if (!$dublicate->get('deleted')) {
                        $dublicate->set('deleted', 1);
                        $dublicate->save();
                    }
		}
                if (!$rcaKey = $this->modx->getOption('tabsaver_rca_key')) {
                    $this->modx->error->addField('url', $this->modx->lexicon('tabsaver_item_err_rca_key'));
                    return false;
                }
                $rcaJSON = file_get_contents('http://rca.yandex.com/?key='.$rcaKey.'&content=full&url='.$url);
                $rca = $this->modx->fromJSON($rcaJSON);
                if (!$rcaJSON || (isset($rca['error_code']) && $rca['error_code'])) {
                    $this->modx->error->addField('url', $this->modx->lexicon('tabsaver_item_err_url'));
                    return false;
                }
                $this->setProperty('title', $rca['title']);
                $this->setProperty('img', array_shift($rca['img']));
                $this->setProperty('content', $rca['content']);
                $this->setProperty('extended', $rcaJSON);
                
		return parent::beforeSet();
	}

}

return 'tabSaverItemCreateProcessor';