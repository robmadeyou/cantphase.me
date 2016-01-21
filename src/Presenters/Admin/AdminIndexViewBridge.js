var bridge = function( presenterPath )
{
	window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function()
{

	var self = this;
	$( '.toPage' ).click( function( event )
	{
		$( '.active' ).removeClass( 'active' );
		$( this ).parent().addClass( 'active' );
		$( '.paged' ).hide();
		var page = $( '#' + $( this ).attr( 'to' ) );
		page.finish();
		page.fadeIn();
		self.registerPresenter();
		event.preventDefault();
		return false;
	} );


	Heartbeat();
	function Heartbeat()
	{
		self.raiseServerEvent( 'Heartbeat', function( data )
		{
			var parsed = JSON.parse( data );
			$( '#server-uptime' ).html( parsed.Uptime );
		});
		setTimeout( Heartbeat, 1000 );
	}
};

window.rhubarb.viewBridgeClasses.AdminIndexViewBridge = bridge;