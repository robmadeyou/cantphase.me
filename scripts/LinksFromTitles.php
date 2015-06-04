<?php
include( __DIR__ . '/simple_html_dom.php' );

$mix = 'https://youtu.be/OvWKklczcsk';

$Songs = [];
exec( 'youtube-dl --get-description ' . $mix, $Songs );
foreach( $Songs as $song )
{
	if( !preg_match( '/((.)+ - (?!http)(.)+)|((dub plate)|(dubplate))/', $song ) )
	{
		continue;
	}
	var_dump( $song );
	$page = file_get_html( "https://duckduckgo.com/html/?q=" . urlencode( $song ) );

	foreach( $page->find( 'div.links_main' ) as $element )
	{
		$url = "http://" . str_replace( ' ', '', $element->find( 'div.url', 0 )->plaintext );
		$output = shell_exec( "youtube-dl -x --audio-quality 0 -i --add-metadata --write-thumbnail --prefer-avconv -o '" . __DIR__ . "/../tmp/%(id)s !i! %(uploader)s !i! %(title)s.%(ext)s' " . escapeshellarg( $url ) );
		print $output;
		continue 2;
	}
}

