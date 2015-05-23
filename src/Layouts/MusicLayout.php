<?php

namespace Cant\Phase\Me\Layouts;


class MusicLayout extends DefaultLayout
{
	protected function printPageHeading()
	{
		?>
		<div id="content" class="wrapper">
			<div class="top"></div>
			<div class="top-bottom">&nbsp;&nbsp;&nbsp;&nbsp
				<span class="top-bar-link" >Visualizer</span><span> | </span>
				<span class="top-bar-link" >Song list</span><span> | </span>
				<span class="top-bar-link" >Favorites</span><span> | </span>
				<span class="top-bar-link" >Playlists</span>
			</div>
			<img id="toolbar-selected" src="/static/image/selectedToolbar.png">
			<script>
				$( '.top-bar-link' ).click( function()
				{
					var toolbarHint = $( '#toolbar-selected' );

					toolbarHint.finish().animate(
						{
							"margin-left" : $( this).position().left + $( this ).width() / 2 - 20
						}
					);
					SelectOption( $( this ) )
				});

				function SelectOption( option )
				{
					$( '.top-bar-link' ).each( function()
					{
						$( this ).removeClass( 'bar-selected' );
					});
					option.addClass( 'bar-selected' )
				}
			</script>
		<?php
	}
}