tabSaver.window.CreateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'tabsaver-item-window-create';
	}
	Ext.applyIf(config, {
		title: _('tabsaver_item_create'),
		width: 550,
		autoHeight: true,
		url: tabSaver.config.connector_url,
		action: 'mgr/item/create',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	tabSaver.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(tabSaver.window.CreateItem, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'textfield',
			fieldLabel: _('tabsaver_item_name'),
			name: 'name',
			id: config.id + '-name',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'textarea',
			fieldLabel: _('tabsaver_item_description'),
			name: 'description',
			id: config.id + '-description',
			height: 150,
			anchor: '99%'
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('tabsaver_item_active'),
			name: 'active',
			id: config.id + '-active',
			checked: true,
		}];
	}

});
Ext.reg('tabsaver-item-window-create', tabSaver.window.CreateItem);


tabSaver.window.UpdateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'tabsaver-item-window-update';
	}
	Ext.applyIf(config, {
		title: _('tabsaver_item_update'),
		width: 550,
		autoHeight: true,
		url: tabSaver.config.connector_url,
		action: 'mgr/item/update',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	tabSaver.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(tabSaver.window.UpdateItem, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
		}, {
			xtype: 'textfield',
			fieldLabel: _('tabsaver_item_name'),
			name: 'name',
			id: config.id + '-name',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'textarea',
			fieldLabel: _('tabsaver_item_description'),
			name: 'description',
			id: config.id + '-description',
			anchor: '99%',
			height: 150,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('tabsaver_item_active'),
			name: 'active',
			id: config.id + '-active',
		}];
	}

});
Ext.reg('tabsaver-item-window-update', tabSaver.window.UpdateItem);