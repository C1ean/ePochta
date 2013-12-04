ePochta.panel.Home = function(config) {
	config = config || {};
	Ext.apply(config,{
		border: false
		,baseCls: 'modx-formpanel'
		,items: [{
			html: '<h2>'+_('epochta')+'</h2>'
			,border: false
			,cls: 'modx-page-header container'
		},{
			xtype: 'modx-tabs'
			,bodyStyle: 'padding: 10px'
			,defaults: { border: false ,autoHeight: true }
			,border: true
			,activeItem: 0
			,hideMode: 'offsets'
			,items: [{
				title: _('epochta_items')
				,items: [{
					html: _('epochta_intro_msg')
					,border: false
					,bodyCssClass: 'panel-desc'
					,bodyStyle: 'margin-bottom: 10px'
				},{
					xtype: 'epochta-grid-items'
					,preventRender: true
				}]
			}]
		}]
	});
	ePochta.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(ePochta.panel.Home,MODx.Panel);
Ext.reg('epochta-panel-home',ePochta.panel.Home);
