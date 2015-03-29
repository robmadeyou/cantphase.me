<?php

namespace Cant\Phase\Me\Model\Music;

use Rhubarb\Scaffolds\Authentication\LoginProvider;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\AndGroup;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class MusicFavorite extends Model
{

	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblMusicFavorite" );
		$schema->addColumn(
			new AutoIncrement( "MusicFavoriteID" ),
			new ForeignKey( "UserID" ),
			new ForeignKey( "MusicID" )
		);

		return $schema;
	}

	public static function IsLoggedInUserFavoriteSong( $songID )
	{
		try
		{
			$isFavorite = self::findFirst( new AndGroup( [ new Equals( "UserID", (new LoginProvider())->getLoggedInUser()->UserID ), new Equals( "MusicID", $songID ) ] ) );
			return true;
		}
		catch( RecordNotFoundException $ex )
		{
			return false;
		}
	}
}