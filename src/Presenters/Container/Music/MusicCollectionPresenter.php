<?php

namespace Cant\Phase\Me\Presenters\Container\Music;

use Cant\Phase\Me\Model\Music\Music;
use Cant\Phase\Me\Model\Music\MusicFavorite;
use Cant\Phase\Me\Model\Music\MusicHistory;
use Cant\Phase\Me\Model\Music\MusicSettings;
use Rhubarb\Crown\DateTime\RhubarbDateTime;
use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Leaf\Presenters\Forms\Form;
use Rhubarb\Scaffolds\Authentication\LoginProvider;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\AndGroup;
use Rhubarb\Stem\Filters\Contains;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Filters\Not;
use Rhubarb\Stem\Repositories\MySql\MySql;

class MusicCollectionPresenter extends Form
{
	protected function createView()
	{
		return new MusicCollectionView();
	}

	protected function configureView()
	{
		ResourceLoader::loadResource( "/static/css/music/music.css" );

		parent::configureView();

		$this->view->attachEventHandler( "FavoriteSong", function( $songID )
		{
			$userID = (new LoginProvider())->getLoggedInUser()->UserID;
			try
			{
				$isFavorite = MusicFavorite::findFirst( new AndGroup( [ new Equals( "UserID", $userID ), new Equals( "MusicID", $songID ) ] ) );
				$isFavorite->delete();
				return false;
			}
			catch( RecordNotFoundException $ex )
			{
				$favorite = new MusicFavorite();
				$favorite->UserID = $userID;
				$favorite->MusicID = $songID;
				$favorite->save();
				return true;
			}
			return false;
		} );

		$this->view->attachEventHandler( "VolumeChange", function( $volume )
		{
			$setting = MusicSettings::GetSettingsForLoggedInUser();
			$setting->Volume = $volume;
			$setting->save();
		} );

		$this->view->attachEventHandler( "ToggleVisualizer", function()
		{
			$setting = MusicSettings::GetSettingsForLoggedInUser();
			$setting->ShowVisualizer = !$setting->ShowVisualizer;
			$setting->save();
		} );

		$this->view->attachEventHandler( "GetNewSong", function( $filter = "" )
		{
			$song = new \stdClass();
			if( $filter === true && $this->songID )
			{
				$filter = $this->songID;

				try
				{
					$songModel = new Music( $filter );
					$song->name = $songModel->Name;
					$song->image = $songModel->Image;
					$song->id = $songModel->MusicID;
				}
				catch( \Exception $ex )
				{
				}
			}
			else if( $filter !== true  && intval( $filter ) )
			{
				try
				{
					$songModel = new Music( $filter );
					$song->name = $songModel->Name;
					$song->image = $songModel->Image;
					$song->id = $songModel->MusicID;
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

				$song->image = $data[ 0 ][ "Image" ];
				$song->name = $data[ 0 ][ "Name" ];
				$song->id = $data[ 0 ][ "MusicID" ];
			}

			$history = new MusicHistory();
			$history->MusicID = $song->id;
			$history->UserID = (new LoginProvider())->getLoggedInUser()->UniqueIdentifier;
			$history->RequestedAt = new RhubarbDateTime( "now" );
			$history->save();

			$song->isFavorite = MusicFavorite::IsLoggedInUserFavoriteSong( $song->id );


			return json_encode( $song );
		} );

		$this->view->attachEventHandler( "GetHistorySong", function( $historyID )
		{
			$userModel = (new LoginProvider())->getLoggedInUser();
			if( $historyID )
			{
				$date = ( new MusicHistory( $historyID ) )->RequestedAt;
			}

			$connection = MySql::getDefaultConnection();
			$vals = $connection->prepare( "SELECT * FROM tblMusicHistory WHERE UserID = :UserID" . ( isset( $date ) ? " AND RequestedAt < '" . $date->format( "Y-m-d H:i:s" ) . "'" : "" ) . " ORDER BY RequestedAt DESC LIMIT 1" );
			$vals->execute( [
				"UserID" => $userModel->UserID
			] );

			$end = $vals->fetchAll( \PDO::FETCH_COLUMN );

			$history = new MusicHistory( $end[ 0 ] );
			$songModel = new Music( $history->MusicID );
			$song = new \stdClass();
			$song->historyID = $end[ 0 ];
			$song->name = $songModel->Name;
			$song->image = $songModel->Image;
			$song->isFavorite = MusicFavorite::IsLoggedInUserFavoriteSong( $songModel->MusicID );

			return json_encode( $song );
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
			$output = shell_exec( "youtube-dl -x --audio-quality 0 -i --add-metadata --write-thumbnail --prefer-avconv -o 'tmp/%(id)s !i! %(uploader)s !i! %(title)s.%(ext)s' " . escapeshellarg( $url ) );
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
						$music->UserID = (new LoginProvider())->getLoggedInUser()->UniqueIdentifier;
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