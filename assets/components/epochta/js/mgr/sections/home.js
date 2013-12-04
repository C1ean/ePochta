ePochta.page.Home = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		components: [{
			xtype: 'epochta-panel-home'
			,renderTo: 'epochta-panel-home-div'
		}]
	}); 
	ePochta.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(ePochta.page.Home,MODx.Component);
Ext.reg('epochta-page-home',ePochta.page.Home);