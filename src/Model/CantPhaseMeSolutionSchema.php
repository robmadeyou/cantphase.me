<?php

namespace Cant\Phase\Me\Model;

use Rhubarb\Stem\Schema\SolutionSchema;

class CantPhaseMeSolutionSchema extends SolutionSchema
{
	public function __construct( )
	{
		parent::__construct( 0.015 );

		$this->addModel( "PhasedUser",    __NAMESPACE__ . '\PhasedUser\PhasedUser' );
		$this->addModel( "Music",         __NAMESPACE__ . '\Music\Music' );
		$this->addModel( "MusicSettings", __NAMESPACE__ . '\Music\MusicSettings' );
		$this->addModel( "MusicHistory",  __NAMESPACE__ . '\Music\MusicHistory' );
		$this->addModel( "MusicFavorite", __NAMESPACE__ . '\Music\MusicFavorite' );
		$this->addModel( "PageContainer", __NAMESPACE__ . '\Container\PageContainer' );
		$this->addModel( "Visit",         __NAMESPACE__ . '\Visit' );
		$this->addModel( "Playlist",      __NAMESPACE__ . '\Music\Playlist' );
		$this->addModel( "PlaylistSongs", __NAMESPACE__ . '\Music\PlaylistSongs' );
	}

	protected function defineRelationships()
	{
		parent::defineRelationships();

		$this->declareManyToManyRelationships(
			[
				"Playlist" =>
				[
					"Songs" => "PlaylistSongs.PlaylistID_Music.MusicID:Playlists"
				]
			]
		);
	}
}