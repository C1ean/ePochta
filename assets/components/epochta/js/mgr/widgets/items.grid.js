ePochta.grid.Items = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		id: 'epochta-grid-items'
		,url: ePochta.config.connector_url
		,baseParams: {
			action: 'mgr/item/getlist'
		}
		,fields: ['id','name','description']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,columns: [
			{header: _('id'),dataIndex: 'id',width: 70}
			,{header: _('name'),dataIndex: 'name',width: 200}
			,{header: _('description'),dataIndex: 'description',width: 250}
		]
		,tbar: [{
			text: _('epochta_item_create')
			,handler: this.createItem
			,scope: this
		}]
		,listeners: {
			rowDblClick: function(grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateItem(grid, e, row);
			}
		}
	});
	ePochta.grid.Items.superclass.constructor.call(this,config);
};
Ext.extend(ePochta.grid.Items,MODx.grid.Grid,{
	windows: {}

	,getMenu: function() {
		var m = [];
		m.push({
			text: _('epochta_item_update')
			,handler: this.updateItem
		});
		m.push('-');
		m.push({
			text: _('epochta_item_remove')
			,handler: this.removeItem
		});
		this.addContextMenuItem(m);
	}
	
	,createItem: function(btn,e) {
		if (!this.windows.createItem) {
			this.windows.createItem = MODx.load({
				xtype: 'epochta-window-item-create'
				,listeners: {
					'success': {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createItem.fp.getForm().reset();
		this.windows.createItem.show(e.target);
	}

	,updateItem: function(btn,e,row) {
		if (typeof(row) != 'undefined') {this.menu.record = row.data;}
		var id = this.menu.record.id;

		MODx.Ajax.request({
			url: ePochta.config.connector_url
			,params: {
				action: 'mgr/item/get'
				,id: id
			}
			,listeners: {
				success: {fn:function(r) {
					if (!this.windows.updateItem) {
						this.windows.updateItem = MODx.load({
							xtype: 'epochta-window-item-update'
							,record: r
							,listeners: {
								'success': {fn:function() { this.refresh(); },scope:this}
							}
						});
					}
					this.windows.updateItem.fp.getForm().reset();
					this.windows.updateItem.fp.getForm().setValues(r.object);
					this.windows.updateItem.show(e.target);
				},scope:this}
			}
		});
	}

	,removeItem: function(btn,e) {
		if (!this.menu.record) return false;
		
		MODx.msg.confirm({
			title: _('epochta_item_remove')
			,text: _('epochta_item_remove_confirm')
			,url: this.config.url
			,params: {
				action: 'mgr/item/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': {fn:function(r) { this.refresh(); },scope:this}
			}
		});
	}
});
Ext.reg('epochta-grid-items',ePochta.grid.Items);




ePochta.window.CreateItem = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('epochta_item_create')
		,id: this.ident
		,height: 200
		,width: 475
		,url: ePochta.config.connector_url
		,action: 'mgr/item/create'
		,fields: [
			{xtype: 'textfield',fieldLabel: _('name'),name: 'name',id: 'epochta-'+this.ident+'-name',anchor: '99%'}
			,{xtype: 'textarea',fieldLabel: _('description'),name: 'description',id: 'epochta-'+this.ident+'-description',height: 150,anchor: '99%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	ePochta.window.CreateItem.superclass.constructor.call(this,config);
};
Ext.extend(ePochta.window.CreateItem,MODx.Window);
Ext.reg('epochta-window-item-create',ePochta.window.CreateItem);


ePochta.window.UpdateItem = function(config) {
	config = config || {};
	this.ident = config.ident || 'meuitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('epochta_item_update')
		,id: this.ident
		,height: 200
		,width: 475
		,url: ePochta.config.connector_url
		,action: 'mgr/item/update'
		,fields: [
			{xtype: 'hidden',name: 'id',id: 'epochta-'+this.ident+'-id'}
			,{xtype: 'textfield',fieldLabel: _('name'),name: 'name',id: 'epochta-'+this.ident+'-name',anchor: '99%'}
			,{xtype: 'textarea',fieldLabel: _('description'),name: 'description',id: 'epochta-'+this.ident+'-description',height: 150,anchor: '99%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	ePochta.window.UpdateItem.superclass.constructor.call(this,config);
};
Ext.extend(ePochta.window.UpdateItem,MODx.Window);
Ext.reg('epochta-window-item-update',ePochta.window.UpdateItem);