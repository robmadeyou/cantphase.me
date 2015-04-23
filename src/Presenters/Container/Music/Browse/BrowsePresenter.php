<?php

namespace Cant\Phase\Me\Presenters\Container\Music\Browse;

use Cant\Phase\Me\Model\Music\MusicFavorite;
use Rhubarb\Leaf\Presenters\Forms\Form;
use Rhubarb\Scaffolds\Authentication\LoginProvider;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\AndGroup;
use Rhubarb\Stem\Filters\Equals;

class BrowsePresenter extends Form
{
	protected function createView()
	{
		return new BrowseView();
	}

	protected function configureView()
	{
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
		} );
	}
}