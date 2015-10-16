<?php
include( __DIR__ . '/simple_html_dom.php' );

$mix = 'https://youtu.be/yX9qwWYAk7E';

$Songs = [];
exec( 'youtube-dl --get-description ' . $mix, $Songs );
foreach( $Songs as $song )
{
	if( !preg_match( '/((.)+ - (?!http)(.)+)|((dub plate)|(dubplate))/', $song ) )
	{
		continue;
	}
	var_dump( $song );
	$page = file_get_contents( "http://ajax.googleapis.com/ajax/services/search/video?q=" . urlencode( $song ) . "&v=1.0" );
	$url = str_replace( ' ', '', json_decode( $page )->responseData->results[0]->url );
	$output = shell_exec( "youtube-dl -x --audio-quality 0 -i --add-metadata --write-thumbnail --prefer-avconv -o '" . __DIR__ . "/../tmp/%(id)s !i! %(uploader)s !i! %(title)s.%(ext)s' " . escapeshellarg( $url ) );
	print $output;
}

