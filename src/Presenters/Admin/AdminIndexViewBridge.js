var bridge = function (presenterPath) {
	window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge.apply(this, arguments);
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function () {
	var self = this;
	self.raiseServerEvent( 'LoadItemsIntoSLQ', function( lol )
	{
		console.log( lol );
	});
};

window.rhubarb.viewBridgeClasses.AdminIndexViewBridge = bridge;