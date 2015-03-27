<?php

namespace Cant\Phase\Me\Presenters\Music;

use Rhubarb\Crown\Context;

class MusicItemPresenter extends MusicCollectionPresenter
{
	public function __construct( $name = "" )
	{
		parent::__construct( $name );

		$context = new Context();
		$this->songID = str_replace( "/", "", str_replace( "/music/", "", $context[ "Request" ][ "ServerData" ][ "SCRIPT_URL" ] ) );
	}

}