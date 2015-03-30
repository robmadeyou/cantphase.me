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
	var hasCanvas = false;
	var currentlyPlayingAudio;
	if( canvas )
	{
		hasCanvas = true;
		var ctx = canvas.getContext( "2d" );
		canvas.width  = canvas.offsetWidth;
		canvas.height = canvas.offsetHeight;
	}
	var volume = 1;
	var songList = [];
	var currentSong;
	var self = this;

	var mouse = {x: 0, y: 0};

	document.addEventListener('mousemove', function(e){
		mouse.x = e.clientX || e.pageX;
		mouse.y = e.clientY || e.pageY
	}, false);



	var dropdown = {
		jquery :  $( '.visualizer-dropdown-overlay' ),
		searchJquery : $( '.visualizer-dropdown-overlay' ).find( "#search"),
		mainSelectionJquery: $( "#visualizer-main-selection"),
		extraItemsJquery : $( "#visualizer-main-selection").find( '.visualizer-dropdown-items' ),
		addSongItemsJquery : $( '#visualizer-add-song' ),
		addSongButtonJquery : $( '#visualizer-dropdown-new-song' ),
		addSongBackButtonJquery : $( '.visualizer-dropdown-add-song-back-button' ),
		visualizerToggleButtonJquery : $( '#visualizer-dropdown-visualizer-toggle' ),
		isOpen : false,
		isSearching : false,
		width : 200,
		height : 200,
		songSearchWidth : 300,
		songSearchHeight : '500',
		animationSpeed : 'fast',
		open : function()
		{
			$( ".visualizer-menu-dropdown" ).fadeOut();
			if( this.isSearching )
			{
				this.searchActivate();
				dropdown.isOpen = true;
			}
			else
			{
				this.jquery.show().animate(
					{
						width : this.width,
						height : this.height
					}, this.animationSpeed, function( )
					{
						dropdown.isOpen = true;
					});
			}
		},
		close : function()
		{
			$( ".visualizer-menu-dropdown" ).fadeIn();
			this.jquery.animate(
				{
					width : 0,
					height : 0
				}, this.animationSpeed,function()
				{
					dropdown.jquery.hide();
				});
			this.isOpen = false;
		},
		searchActivate : function()
		{
			this.jquery.show().animate(
				{
					width : this.songSearchWidth,
					height : this.songSearchHeight
				}, this.animationSpeed
			);
			this.searchJquery.fadeIn();
			this.extraItemsJquery.hide();

			this.isSearching = true;
		},
		searchDeactivate : function()
		{
			this.jquery.animate(
				{
					width : this.width,
					height : this.height
				}, this.animationSpeed
			);
			this.extraItemsJquery.show();
			this.searchJquery.fadeOut();
			this.isSearching = false;
		},
		openAddSong : function()
		{
			this.mainSelectionJquery.fadeOut();
			this.addSongItemsJquery.fadeIn();
		},
		closeAddSong : function()
		{
			this.mainSelectionJquery.fadeIn();
			this.addSongItemsJquery.fadeOut();
		},
		initialize : function()
		{
			this.addSongButtonJquery.click( function()
			{
				dropdown.openAddSong();
			} );

			this.addSongBackButtonJquery.click( function()
			{
				dropdown.closeAddSong();
			} );

			$( '.song-upload' ).keyup( function( event )
			{
				if( event.which == 13 )
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

					self.raiseServerEvent( "Download", url, notes, tags, usePrefix, prefix, function( message )
					{
						alert( message );
						dropdown.closeAddSong();
					} );
				}
			} );

			this.visualizerToggleButtonJquery.click( function()
			{
				self.raiseServerEvent( "ToggleVisualizer", function()
				{
					if( canvas )
					{
						$( canvas ).fadeOut();
						location.reload();
					}
					else
					{
						location.reload();
					}
				} )
			})
		}
	};

	function init( data )
	{
		if( data.isFavorite )
		{
			$( "#favorite-button img" ).attr( "src", "/static/image/songFavouriteSelect.png" )
		}
		else
		{
			$( "#favorite-button img" ).attr( "src", "/static/image/songFavouriteUnSelect.png" )
		}
		currentSong =  data;
		if( hasCanvas )
		{
			initCanvas( data )
		}
		else
		{
			initAudio( data )
		}
	}

	function stopAudio()
	{
		if( hasCanvas )
		{
			soundInstance.stop();
		}
		else
		{
			currentlyPlayingAudio.pause();
		}
	}

	function playAudio()
	{
		if( hasCanvas )
		{
			soundInstance.play();
		}
		else
		{
			currentlyPlayingAudio.play();
		}
	}

	function pauseAudio()
	{
		if( hasCanvas )
		{
			soundInstance.pause();
		}
		else
		{
			currentlyPlayingAudio.pause();
		}
	}

	function initCanvas( song )
	{
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

	function initAudio( data )
	{
		$( "#img" ).attr( "src", "/static/music/" + data.image );
		$( "#songTitle" ).html( data.name );
		if( currentlyPlayingAudio )
		{
			currentlyPlayingAudio.pause();
		}
		else
		{
			currentlyPlayingAudio = new Audio();
		}
		$( currentlyPlayingAudio ).on( 'ended', function()
		{
			playNextSong();
		});
		currentlyPlayingAudio.src = assetsPath + data.name;
		currentlyPlayingAudio.play();
		currentlyPlayingAudio.volume = volume;
		console.log( volume );
		console.log( currentlyPlayingAudio.volume )
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
	var lastTotal = 0;
	function tick(evt) {
		analyserNode.getFloatFrequencyData(freqFloatData);  // this gives us the dBs
		analyserNode.getByteFrequencyData(freqByteData);  // this gives us the frequency
		analyserNode.getByteTimeDomainData(timeByteData);  // this gives us the waveform
		//ctx.clearRect(0,0,canvas.width,canvas.height);
		if( soundInstance.volume != volume )
		{
			soundInstance.volume = volume;
		}

		canvas.width = canvas.width;
		ctx.fillStyle = "#3D2117";
		var width = Math.ceil(canvas.width / freqByteData.length)

		var lastX = 0;
		var lastY = 0;

		ctx.restore();
		var rotat = 0;
		var total = 0;
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
			var initialRotate = ( i * 12.5 ) * Math.PI / 180;
			ctx.rotate( initialRotate + tickrotate );
			ctx.save();
			if(1+(freqFloatData[ i ] / 100) < 1 )
			{
				ctx.globalAlpha = 1.1+(freqFloatData[ i ] / 100);
			}
			var grd=ctx.createLinearGradient(0,0,50,0);
			grd.addColorStop(0,"yellow");
			grd.addColorStop(1,"red");

			ctx.fillStyle=grd;

			if( i > ( freqByteData.length / 5 ) * 3 )
			{
				ctx.fillRect( 100, 360, -freqByteData[i], width + 2 );
			}
			else
			{
				ctx.fillRect( 100, -120, freqByteData[i], width + 2 );
			}

			ctx.restore();
			ctx.restore();
			total += freqByteData[ i ];
		}
		tickrotate += 0.0024;
		ctx.restore();
		var difference = lastTotal - total;
		ctx.save();


		lastTotal = total;
	}

	$( "#searchIn" ).keyup(function()
	{
		var text = $(this).val();

		if( text == "" )
		{
			dropdown.searchDeactivate();
		}
		else
		{
			dropdown.searchActivate();
		}

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
				var margin = 0;
				link.hover(
					function() {
						var self = this;
						onHover = setInterval( function()
						{
							obj = $( self );
							console.log(  obj.width() + dropdown.songSearchWidth  );
							if( margin < obj.width() - dropdown.songSearchWidth )
							{
								obj.css({"margin-left": '-=1'})
								margin++;
							}
						}, 10 );
					},
					function() {
						clearInterval( onHover );
						$( this ).animate( { "margin-left" : 0 }, 400 );
						margin = 0;
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

	function changeVolume( vol )
	{
		self.raiseServerEvent( "VolumeChange", vol );
		volume = vol / 100;
		if( !hasCanvas )
		{
			if( currentlyPlayingAudio )
			{

				currentlyPlayingAudio.volume = vol / 100.0;
			}
		}
	}


	function getRandomSong()
	{
		self.raiseServerEvent( "GetNewSong", false, function( data )
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

	function playPreviousSong()
	{
		var historyID = currentSong && currentSong.historyID ? currentSong.historyID : 0;
		self.raiseServerEvent( "GetHistorySong", historyID, function( song )
		{
			next( JSON.parse( song ) );
		} )
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
		dropdown.initialize();

		$( "#favorite-button" ).click( function()
		{
			self.raiseServerEvent( "FavoriteSong", currentSong.id, function ( back )
			{
				if( back == "1" )
				{
					$( "#favorite-button img" ).attr( "src", "/static/image/songFavouriteSelect.png" )
				}
				else
				{
					$( "#favorite-button img" ).attr( "src", "/static/image/songFavouriteUnSelect.png" )
				}
			} )
		} );

		$( '#stop-button' ).click( function()
		{
			stopAudio();
		} );

		$( '#play-button' ).click( function()
		{
			playAudio();
		} );

		$( '#pause-button' ).click( function()
		{
			pauseAudio();
		} );


		$( "#nextButton" ).click( function()
		{
			playNextSong();
		} );

		$( "#prevButton" ).click( function()
		{
			playPreviousSong();
		} );

		$( "#volume" ).change(function() {
			var val = $( this ).val();
			changeVolume( val );
			$( '.visualizer-slider-percentage' ).html( val + "%" );
			$( '.visualizer-slider-percentage' ).show().delay( 400 ).fadeOut();
		});

		self.raiseServerEvent( "GetNewSong", true, function( song )
		{
			changeVolume( $( "#volume" ).val() );
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
			var parent = $( "#visualizer-overlay" ).offset();
			var rect = this.getBoundingClientRect();
			console.log( mouse );
			dropdown.jquery.css( { top: rect.bottom - rect.height - parent.top, left : rect.left - parent.left } );
			dropdown.open();
			dropdown.jquery.height( 400 );
			return false;
		} );
	});
};

window.gcd.core.mvp.viewBridgeClasses.MusicCollectionViewBridge = bridge;