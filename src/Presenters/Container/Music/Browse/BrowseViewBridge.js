var bridge = function( presenterPath )
{
	window.gcd.core.mvp.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
}

bridge.prototype = new window.gcd.core.mvp.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function()
{
	this.populateEvents();
};

bridge.prototype.onSubPresenterValueChanged = function( name, value )
{
	if( name.presenterName == 1 )
	{
		this.populateEvents();
	}
};

bridge.prototype.populateEvents = function()
{
	var self = this;
	$( '.image-container' ).click( function()
	{
		var element = $( this );
		self.raiseServerEvent( "FavoriteSong", $( this ).attr( "musicId" ), function( val )
		{
			if( val == "1" )
			{
				element.find( 'img' ).attr( "src", '/static/image/songFavouriteSelect.png' );
			}
			else
			{
				element.find( 'img' ).attr( "src", '/static/image/songFavouriteUnSelect.png' );
			}
		});
	} );
}

window.gcd.core.mvp.viewBridgeClasses.BrowseViewBridge = bridge;