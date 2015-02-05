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
		}
		elseif ($dublicate = $this->modx->getObject($this->classKey, array('url' => $url, 'uid' => $uid))) {
                    if (!$dublicate->get('deleted')) {
                        $dublicate->set('deleted', 1);
                        $dublicate->save();
                    }
		}
                $rcaKey = $this->modx->getOption('tabsaver_rca_key');
                $rca = $this->modx->fromJSON(file_get_contents('http://rca.yandex.com/?key='.$rcaKey.'&content=full&url='.$url));
                $this->setProperty('title', $rca['title']);
                $this->setProperty('img', array_shift($rca['img']));
                $this->setProperty('content', $rca['content']);
                $this->setProperty('extended', $this->modx->toJSON($rca));
                
		return parent::beforeSet();
	}

}

return 'tabSaverItemCreateProcessor';