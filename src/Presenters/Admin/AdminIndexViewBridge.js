var bridge = function (presenterPath) {
	window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge.apply(this, arguments);
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function () {

	var self = this;
	$( '.toPage').click( function( event )
	{
		$( '.active').removeClass( 'active' );
		$( this ).parent().addClass( 'active' );
		self.raiseServerEvent( 'GetPage', $( this ).attr( 'to' ), function( data )
		{
			var page = $( '#page-container' );
			page.finish();
			page.fadeOut( 600, function()
			{
				page.html( data );
				page.fadeIn();
				self.registerPresenter();
			});
		});
		event.preventDefault();
		return false;
	});
};

window.rhubarb.viewBridgeClasses.AdminIndexViewBridge = bridge;