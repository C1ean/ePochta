var ePochta = function(config) {
	config = config || {};
	ePochta.superclass.constructor.call(this,config);
};
Ext.extend(ePochta,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('epochta',ePochta);

ePochta = new ePochta();