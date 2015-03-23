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
        self.raiseServerEvent( "login", self.user, self.pass, self.email, self.info, function ( out )
        {
            debugger;
        } );
    } );
};

window.gcd.core.mvp.viewBridgeClasses.IndexViewBridge = bridge;