var bridge = function( presenterPath )
{
	window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

var running = false;

bridge.prototype.attachEvents = function()
{

};

window.rhubarb.viewBridgeClasses.NpcEditViewBridge = bridge;