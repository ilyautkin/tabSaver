var tabSaver = function (config) {
	config = config || {};
	tabSaver.superclass.constructor.call(this, config);
};
Ext.extend(tabSaver, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('tabsaver', tabSaver);

tabSaver = new tabSaver();