<?php
namespace Cant\Phase\Me\Scripts;

use Cant\Phase\Me\Model\Music\Music;

$bookmarks = simplexml_load_file( __DIR__ . '/bookmarks.xml' );

foreach( $bookmarks->DL  as $entry )
{
	$tags = $entry->H3;
	foreach( $entry as $e )
	{
		$url = str_replace( "!#amp;", "&", $e[ "HREF" ] );
		print str_replace( "!#amp;", "&", $e[ "HREF" ] ) . "\n";

		$errors = "";
		$songList = [];
		$dir = __DIR__ . "/../";
		$url = str_replace( ";", "", $url );
		$output = shell_exec( "youtube-dl -x --audio-quality 0 -i --add-metadata --write-thumbnail --prefer-avconv -o '" . __DIR__ . "/../tmp/%(id)s !i! %(uploader)s !i! %(title)s.%(ext)s' " . $url );
		print $output;
		$directory = scandir( "$dir/tmp/" );
		foreach( $directory as $item )
		{
			if( $item != '.' && $item != '..' )
			{
				$info = pathinfo( $item );
				if( $info[ "extension" ] == "mp3" || $info[ "extension" ] == "m4a" )
				{
					$songExploded = explode( " !i! ", $item );
					$songName = $songExploded[ 2 ];
					$songUrl = $songExploded[ 0 ];
					$uploader = $songExploded[ 1 ];
					$image = str_replace( $info[ "extension" ], "jpg", $songName );
					$music = new Music();
					$music->Url = $url;
					$music->Genre = $tags;
					$music->Notes = "Neverlost's bookmarks";
					$music->Name = $songName;
					$music->Image = $image;
					$music->Uploader = $uploader;
					$music->Source = $songUrl;
					$music->UserID = 3;
					$music->save();

					rename( "$dir/tmp/" . $item, "$dir/static/music/" . $songName );
					rename( "$dir/tmp/" . str_replace( $info[ "extension" ], "jpg", $item ), "$dir/static/music/" . $image );
				}
			}
		}
	}
}