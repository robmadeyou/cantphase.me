var bridge = function( presenterPath )
{
	window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

var running = false;

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
		event.preventDefault();
		return false;
	} );


	if( !running )
	{
		Heartbeat();
		function Heartbeat() {
			self.raiseServerEvent('Heartbeat', function (parsed) {
				$('#server-uptime').html(parsed.Uptime);
				$('#players-online-holder').html(parsed.Online);
			});
			setTimeout(Heartbeat, 1000);
		}
		running = true;
	}
};

window.rhubarb.viewBridgeClasses.AdminIndexViewBridge = bridge;