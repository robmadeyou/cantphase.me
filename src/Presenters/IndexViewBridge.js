var bridge = function( presenterPath )
{
    window.gcd.core.mvp.viewBridgeClasses.HtmlViewBridge.apply( this, arguments );
}

bridge.prototype = new window.gcd.core.mvp.viewBridgeClasses.HtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function()
{
	alert( "hi" );
}

window.gcd.core.mvp.viewBridgeClasses.IndexViewBridge = bridge;