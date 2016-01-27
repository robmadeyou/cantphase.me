var bridge = function( presenterPath )
{
	window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

var running = false;

bridge.prototype.attachEvents = function()
{

	var updateTimeout = 1000;

	if( window.location.hash )
	{
		goToPage( window.location.hash.replace( "#", "" ) );
	}

	var self = this;
	$( '.toPage' ).click( function( event )
	{
		goToPage( $( this ).attr( 'to' ) );
		$( this ).parent().addClass( 'active' );
		event.preventDefault();
		return false;
	} );

	function goToPage( name )
	{
		$( '.active' ).removeClass( 'active' );
		$( '.paged' ).hide();
		var page = $( '#' + name );
		page.finish();
		page.fadeIn();
	}


	if( !running )
	{
		Heartbeat();
		function Heartbeat() {
			self.raiseServerEvent('Heartbeat', function (parsed) {
				$('#server-uptime').html(parsed.Uptime);
				$('#players-online-holder').html(parsed.Online);
			});
			setTimeout(Heartbeat, updateTimeout);
		}
		running = true;
	}
};

window.rhubarb.viewBridgeClasses.AdminIndexViewBridge = bridge;