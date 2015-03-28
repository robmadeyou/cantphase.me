var bridge = function( presenterPath )
{
	window.gcd.core.mvp.viewBridgeClasses.JqueryHtmlViewBridge.apply( this, arguments );
}

bridge.prototype = new window.gcd.core.mvp.viewBridgeClasses.JqueryHtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function()
{
	var self = this;
	var FFTSIZE = 1024;      // number of samples for the analyser node FFT, min 32
	var TICK_FREQ = 20;     // how often to run the tick function, in milliseconds
	var image = 0;
	var assetsPath = "/static/music/"; // Create a single item to load.
	var src = "";  // set up our source
	var soundInstance;      // the sound instance we create
	var analyserNode;       // the analyser node that allows us to visualize the audio
	var freqFloatData, freqByteData, timeByteData;  // arrays to retrieve data from analyserNode
	var canvas = document.getElementById( "barCanvas" );
	var ctx = canvas.getContext( "2d" );
	var volume = 1;
	var songList = [];
	var currentSong;
	var self = this;


	var dropdown = {
		jquery :  $( '.visualizer-dropdown-overlay' ),
		isOpen : false,
		isSearching : false,
		animationSpeed : 'fast',
		open : function()
		{
			this.jquery.show().animate(
				{
					width : 200,
					height : 200
				}, this.animationSpeed, function(  )
				{
					dropdown.isOpen = true;
				});
		},
		close : function()
		{
			this.jquery.animate(
				{
					width : 0,
					height : 0
				}, this.animationSpeed,function()
				{
					dropdown.jquery.hide();
				});
			this.isOpen = false;
		}
	};

	var mouse = {x: 0, y: 0};

	document.addEventListener('mousemove', function(e){
		mouse.x = e.clientX || e.pageX;
		mouse.y = e.clientY || e.pageY
	}, false);

	canvas.width  = canvas.offsetWidth;
	canvas.height = canvas.offsetHeight;


	function init( song ) {
		currentSong = song.name;
		$( "#img" ).attr( "src", "/static/music/" + song.image );
		$( "#songTitle" ).html( song.name );

		if( song != "" )
		{
			if( assetsPath + src == assetsPath + song.name )
			{
				handleLoad(this);
				return;
			}
			else
			{
				src = song.name;
			}
		}
		if (window.top != window) {
			document.getElementById("header").style.display = "none";
		}

		// Web Audio only demo, so we register just the WebAudioPlugin and if that fails, display fail message
		if (!createjs.Sound.registerPlugins([createjs.WebAudioPlugin])) {
			document.getElementById("error").style.display = "block";
			//return;
		}

		// create a new stage and point it at our canvas:
		createjs.Sound.addEventListener("fileload", createjs.proxy(handleLoad,this)); // add an event listener for when load is completed
		createjs.Sound.registerSound(assetsPath + src );  // register sound, which preloads by default

	}

	function handleLoad(evt) {
		var context = createjs.Sound.activePlugin.context;
		analyserNode = context.createAnalyser();
		analyserNode.fftSize = FFTSIZE;  //The size of the FFT used for frequency-domain analysis. This must be a power of two
		analyserNode.smoothingTimeConstant = 0.85;  //A value from 0 -> 1 where 0 represents no time averaging with the last analysis frame
		analyserNode.connect(context.destination);  // connect to the context.destination, which outputs the audio
		var dynamicsNode = createjs.Sound.activePlugin.dynamicsCompressorNode;
		dynamicsNode.disconnect();  // disconnect from destination
		dynamicsNode.connect(analyserNode);
		freqFloatData = new Float32Array(analyserNode.frequencyBinCount);
		freqByteData = new Uint8Array(analyserNode.frequencyBinCount);
		timeByteData = new Uint8Array(analyserNode.frequencyBinCount);
		startPlayback(evt);
	}

	function startPlayback(evt) {
		soundInstance = createjs.Sound.play(assetsPath + src, {loop:0});
		soundInstance.addEventListener( "complete" , createjs.proxy(playNextSong, this));
		// start the tick and point it at the window so we can do some work before updating the stage:
		createjs.Ticker.addEventListener("tick", tick);
		createjs.Ticker.setInterval(TICK_FREQ);
	}

	function next( song, image )
	{
		this.image = image;

		if( src != "" )
		{
			createjs.Ticker.removeEventListener( "tick", tick );
			createjs.Sound.stop( );
			createjs.Sound.removeAllEventListeners( );
			createjs.Sound.activePlugin.dynamicsCompressorNode.disconnect( );
		}
		init( song );
	}

	var tickrotate = 0;

	function tick(evt) {
		analyserNode.getFloatFrequencyData(freqFloatData);  // this gives us the dBs
		analyserNode.getByteFrequencyData(freqByteData);  // this gives us the frequency
		analyserNode.getByteTimeDomainData(timeByteData);  // this gives us the waveform
		//ctx.clearRect(0,0,canvas.width,canvas.height);
		if( soundInstance.volume != this.volume )
		{
			soundInstance.volume = this.volume;
		}

		canvas.width = canvas.width;
		ctx.fillStyle = "#3D2117";
		var width = Math.ceil(canvas.width / freqByteData.length)

		var lastX = 0;
		var lastY = 0;

		ctx.restore();
		var rotat = 0;
		for( var i = 0; i < freqByteData.length; i++)
		{
			if( i > ( freqByteData.length / 5 ) * 3 )
			{
				ctx.fillStyle = "white";
			}
			else
			{
				ctx.fillStyle = "#4DA6A6";
			}


			if( i == 0 )
			{
				lastX = 0;
				lastY = canvas.height - timeByteData[i];
			}

			ctx.beginPath();
			ctx.strokeStyle =  "#4DA6A6";
			ctx.lineWidth = 6;
			ctx.moveTo( lastX, lastY);
			ctx.lineTo( i * width, canvas.height - timeByteData[i]);
			lastY = canvas.height - timeByteData[i] * 1;
			lastX = i * width;
			ctx.stroke();
			ctx.save();

			ctx.translate( canvas.width / 2, canvas.height / 2);
			var initialRotate = ( i * 3.3 ) * Math.PI / 180;
			ctx.rotate( initialRotate + tickrotate );
			ctx.save();
			if(1+(freqFloatData[ i ] / 100) < 1 )
			{
				ctx.globalAlpha = 1+(freqFloatData[ i ] / 100);
			}

			ctx.fillRect( 100, 0, freqByteData[i], width + 2 );

			ctx.restore();
			ctx.restore();
		}
		tickrotate += 0.0024;
		ctx.restore();
	}

	$( "#searchIn" ).keyup(function()
	{
		var text = $(this).val();

		self.raiseServerEvent( "Search", text, function( data )
		{
			data = JSON.parse( data );
			var search = $( "#search" );
			search.html( "" );
			songList = data;
			for( var i = 0; i < data.length; i++)
			{
				var link = $( '<span id="song-select-' + data[i].id + '" class="_vdo songLink" song="' + data[ i ].id + '" >' + data[ i ].name + '</span>' );
				search.append( link );
				link.hover(
					function() {
						var self = this;
						onHover = setInterval( function()
						{
							$( self ).css( { "margin-left" : '-=1' } )
						}, 10 );
					},
					function() {
						clearInterval( onHover );
						$( this ).animate( { "margin-left" : 0 }, 400 )
					} );
			}

			var songLink = $( ".songLink" );
			var onHover;
			songLink.click( function()
			{
				ajaxGetSong( $( this ).attr( "song" ) );
			});
		} );
	});

	$( "#login" ).click( function()
	{
		var usr = prompt( "What's your username?" )
		$.ajax(
			{
				url : "login/",
				type : "POST",
				data : { user : usr }
			}
		).done( function( response )
			{
				alert( response );
				setCookie( "user", usr, 60 );
				location.reload();
			});
	});

	$( "#logout" ).click( function()
	{
		if( confirm( "Are you sure you want to log out?" ) )
		{
			setCookie( "user", "", 0 );
			location.reload();
		}
	});

	/*
	 Thanks w3!
	 */
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}

	function changeVolume( volume )
	{
		this.volume = volume / 100;
	}

	$( "#finalizePull" ).click(function( event )
	{
		var url = $( "#pullUrl" ).val();
		var tags = $( "#pullTags" ).val();
		var prefix = $( "#pullPrefix" ).val();
		var notes = $( "#pullNotes" ).val();
		var usePrefix = $( "#pullSmartTitle" ).is( ":checked" );

		if( url == "" )
		{
			alert( "Sorry; URL was left empty" );
			return;
		}
		event.preventDefault();

		self.raiseServerEvent( "Download", url, notes, tags, usePrefix, prefix, function( message)
		{
			alert( data );
			$( "#overlay" ).fadeOut();
			$( "#outerPullForm" ).fadeOut();
		} );
	});


	function getRandomSong()
	{
		self.raiseServerEvent( "GetNewSong", "", function( data )
		{
			data = JSON.parse( data );
			console.log( data );
			next( data );
		} );
	}

	function voteOnSong( view )
	{
		$.ajax(
			{
				url : "rate/",
				type : "POST",
				data : { songID : currentSong.id,
					preference : ( view ? 1 : 0 ) }
			}
		).done( function( data )
			{
				console.log( data );
			});

	}

	function playNextSong()
	{
		if( songList.length != 0 )
		{
			next( songList[ parseInt( parseInt( Math.random() * songList.length ) ) ] );
		}
		else
		{
			getRandomSong();
		}
	}

	/**
	 * Get a random song from an ajax call.
	 *
	 * The call will simply return a string with the name of the song.
	 * The JS library will do all the magic afterwards.
	 */
	function ajaxGetSong( song )
	{
		self.raiseServerEvent( "GetNewSong", song, function( data )
		{
			data = JSON.parse( data );
			console.log( data );
			next( data );
		} );
	}

	$( document ).ready( function()
	{

		$( "#volume" ).change(function() {
			var val = $( this ).val();
			changeVolume( val );
			$( '.visualizer-slider-percentage' ).html( val + "%" );
			$( '.visualizer-slider-percentage' ).show().delay( 400 ).fadeOut();
		});

		self.raiseServerEvent( "GetNewSong", true, function( song )
		{
			changeVolume( 20 );
			init( JSON.parse( song ) );
		} );

		$( "#pull" ).click( function( event )
		{
			$( "#overlay" ).fadeIn();
			$( "#outerPullForm" ).fadeIn();
			event.preventDefault();
			return false;
		});

		$( "#close" ).click( function ( event )
		{
			$( "#overlay" ).fadeOut();
			$( "#outerPullForm" ).fadeOut();
			event.preventDefault();
			return false;
		});

		$( "#content" ).click( function( e )
		{
			for( var i = 0; i < e.target.classList.length; i++ )
			{
				if( e.target.classList[ i ] == "_vdo" )
				{
					return false;
				}
			}
			if( dropdown.isOpen && e.target != dropdown.jquery[0] )
			{
				dropdown.close();
				return false;
			}
		});

		$( "#visualizer-dropdown" ).click( function()
		{
			var rect = this.getBoundingClientRect();
			console.log( mouse );
			dropdown.jquery.css( { top: rect.bottom - rect.height, left : rect.left } );
			dropdown.open();
			dropdown.jquery.height( 400 );
			return false;
		} );
	});
};

window.gcd.core.mvp.viewBridgeClasses.MusicCollectionViewBridge = bridge;