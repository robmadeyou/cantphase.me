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

	this.waitForPresenters( [ "username", "password", "info", "email" ], function ( uname, pass, info, email )
	{
		self.user = $( "#" + uname.presenterPath );
		self.pass = $( "#" + pass.presenterPath );
		self.info = $( "#" + info.presenterPath );
		self.email = $( "#" + email.presenterPath );
	} );

	var onLoginScreen = false;
	$( "#login-button" ).click( function()
	{
		$( "#login-base" ).fadeOut( 300 );
		setTimeout( function()
		{
			onLoginScreen = true;
			$( "#actual-login" ).slideDown();
		}, 300 );
	} );

	$( document ).keydown( function( event )
	{
		if( event.which == 13 )
		{
			self.raiseServerEvent( "login", self.user.val(), self.pass.val(), self.info.val(), self.email.val(), function ( out )
			{
				if( out == 2 )
				{
					alert( "Nice, welcome to the club" );
					$( ".overlay" ).fadeOut();
					setTimeout( function()
					{
						window.location.href = "/";
					}, 500 )
				}
			} );
		}
	} );

};

window.gcd.core.mvp.viewBridgeClasses.IndexViewBridge = bridge;