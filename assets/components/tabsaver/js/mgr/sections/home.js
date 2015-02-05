tabSaver.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'tabsaver-panel-home', renderTo: 'tabsaver-panel-home-div'
		}]
	});
	tabSaver.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(tabSaver.page.Home, MODx.Component);
Ext.reg('tabsaver-page-home', tabSaver.page.Home);