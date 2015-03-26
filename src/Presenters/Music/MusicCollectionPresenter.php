<?php

namespace Cant\Phase\Me\Presenters\Music;

use Cant\Phase\Me\Model\Music\Music;
use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Leaf\Presenters\Forms\Form;
use Rhubarb\Stem\Filters\AndGroup;
use Rhubarb\Stem\Filters\Contains;
use Rhubarb\Stem\Filters\Not;
use Rhubarb\Stem\Repositories\MySql\MySql;

class MusicCollectionPresenter extends Form
{
	protected function createView()
	{
		ResourceLoader::loadResource( [ "http://code.createjs.com/easeljs-0.7.1.min.js", "http://code.createjs.com/soundjs-0.5.2.min.js" ] );
		return new MusicCollectionView();
	}

	protected function configureView()
	{
		parent::configureView();

		$this->view->attachEventHandler( "GetNewSong", function( $filter = "" )
		{
			if( $filter )
			{
				try
				{
					$songModel = new Music( $filter );
					$song = new \stdClass();

					$song->name = $songModel->Name;
					$song->image = $songModel->Image;

					return json_encode( $song );
				}
				catch( \Exception $ex )
				{

				}
			}
			else
			{
				$sql = MySql::getDefaultConnection();
				$randSong = $sql->prepare( "SELECT * FROM tblMusic ORDER BY RAND() LIMIT 1" );
				$randSong->execute();
				$data = $randSong->fetchAll( );

				$song = new \stdClass();
				$song->image = $data[ 0 ][ "Image" ];
				$song->name = $data[ 0 ][ "Name" ];
				return json_encode( $song );
			}
		} );

		$this->view->attachEventHandler( "Search", function( $query )
		{
			$title = "";
			$noGenres = [];
			$genres = [];
			$uploader = "";
			preg_match_all( '/@(\w)+/', $query, $title );
			try
			{
				$title = $title[0][0];
			}
			catch( \Exception $ex )
			{
				$title = "";
			}
			preg_match_all( '/\+(\w)+/', $query, $genres );
			$genres = $genres[0];
			preg_match_all( '/-(\w)+/', $query, $noGenres );
			$noGenres = $noGenres[0];
			preg_match_all( '/#(\w)+/', $query, $uploader );
			try
			{
				$uploader = $uploader[0][0];
			}
			catch( \Exception $ex )
			{
				$uploader = "";
			}

			$andFilter = new AndGroup();

			if( $title )
			{
				$andFilter->addFilters( new Contains( 'Name', str_replace( "@", "", $title ) ) );
			}

			if( $noGenres )
			{
				foreach( $noGenres as $noGenre )
				{
					$andFilter->addFilters( new Not( new Contains( "Genre", str_replace( "-", "", $noGenre ) ) ) );
				}
			}

			if( $genres )
			{
				foreach( $genres as $genre )
				{
					$andFilter->addFilters( new Contains( "Genre", str_replace( "+", "", $genre ) ) );
				}
			}

			if( $uploader )
			{
				$andFilter->addFilters( new Contains( "Uploader", str_replace( "#", "", $uploader ) ) );
			}

			$songsArray = [];

			$songs = Music::find( $andFilter );
			$songs->setRange( 0, 150 );

			foreach( $songs as $s )
			{
				$song = new \stdClass();
				$song->name = $s->Name;
				$song->image = $s->Image;
				$song->id = $s->MusicID;
				$songsArray[] = $song;
			}

			return json_encode( $songsArray );
		} );

		$this->view->attachEventHandler( "Download", function( $url, $notes, $tags, $usePrefix, $prefix )
		{
			$errors = "";
			$customPrefix = $prefix;

			$songList = [];
			$dir = getcwd();
			$url = str_replace( ";", "", $url );
			$output = shell_exec( "youtube-dl -x --audio-quality 0 -i --add-metadata --write-thumbnail --prefer-avconv -o 'tmp/%(id)s !i! %(uploader)s !i! %(title)s.%(ext)s' " . $url );
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
						if( $customPrefix != "" )
						{
							if( $usePrefix )
							{
								if( strpos( strtolower( $songName ), strtolower( $customPrefix ) ) ===  false )
								{
									$songName = $customPrefix . " - " . $songName;
								}
							}
						}
						$image = str_replace( $info[ "extension" ], "jpg", $songName );
						$music = new Music();
						$music->Url = $url;
						$music->CustomName = $customPrefix;
						$music->Genre = $tags;
						$music->Notes = $notes;
						$music->Name = $songName;
						$music->Image = $image;
						$music->Uploader = $uploader;
						$music->Source = $songUrl;
						$music->save();

						rename( "$dir/tmp/" . $item, "$dir/static/music/" . $songName );
						rename( "$dir/tmp/" . str_replace( $info[ "extension" ], "jpg", $item ), "$dir/static/music/" . $image );
					}
				}
			}
			return $output;
		} );
	}
}