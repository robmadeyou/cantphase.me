var bridge = function( presenterPath )
{
	window.gcd.core.mvp.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
}

bridge.prototype = new window.gcd.core.mvp.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function()
{

	var user, pass, info, email;

	var self = this;

	this.waitForPresenters( [ "username", "password", "email", "info" ], function ( uname, pass, inf, eml )
	{
		self.user = $( "#" + uname.presenterPath );
		self.pass = $( "#" + pass.presenterPath );
		self.email = $( "#" + inf.presenterPath );
		self.info = $( "#" + eml.presenterPath );
	} );


	$( ".submit-button" ).click( function( )
	{
		debugger;
		self.raiseServerEvent( "login", self.user.val(), self.pass.val(), self.email.val(), self.info.val(), function ( out )
		{
			debugger;
		} );
	} );
};

window.gcd.core.mvp.viewBridgeClasses.IndexViewBridge = bridge;