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

	this.waitForPresenters( [ "username", "password" ], function ( uname, pass )
	{
		self.user = $( "#" + uname.presenterPath );
		self.pass = $( "#" + pass.presenterPath );
	} );

	var onLoginScreen = false;
	$( ".login-click" ).click( function()
	{
		$( ".login-click").parent().fadeOut( 300 );
		setTimeout( function()
		{
			onLoginScreen = true;
			$( ".login-base" ).slideDown();
		}, 300 );
	} );

	$( document ).keydown( function( event )
	{
		if( event.which == 13 )
		{
            var message = $( '.login-message' );
            message.html( 'loading... please wait.' );
			self.raiseServerEvent( "login", self.user.val(), self.pass.val(), function ( out )
			{
				if( out == 1 )
				{
                    message.html( 'Welcome back.' );
					$( ".overlay" ).fadeOut();
					setTimeout( function()
					{
						window.location.href = "/";
					}, 500 )
				}
				else
				{
					message.html( "Try again." );
				}
			} );
		}
	} );

};

window.gcd.core.mvp.viewBridgeClasses.IndexViewBridge = bridge;
