<?php

namespace Cant\Phase\Me\Model\Music;

use Rhubarb\Scaffolds\Authentication\LoginProvider;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Boolean;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Int;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class MusicSettings extends Model
{

	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblMusicSettings" );

		$schema->addColumn(
			new AutoIncrement( "MusicSettingsID" ),
			new ForeignKey( "UserID" ),
			new Boolean( "ShowVisualizer", true ),
			new Int( "Volume", 20 ),
			new Varchar( "PrimaryColor", 6 ),
			new Varchar( "SecondaryColor", 6 )
		);

		return $schema;
	}

	/**
	 *
	 * Gets the user settings for a specific user, if settings don't exist, they are created
	 * and returned.
	 *
	 * @param $userID
	 *
	 * @return MusicSettings|Model
	 * @throws \Exception
	 * @throws \Rhubarb\Stem\Exceptions\ModelConsistencyValidationException
	 */
	public static function GetSettingsForUser( $userID )
	{
		try
		{
			$settings = MusicSettings::findFirst( new Equals( "UserID", $userID ) );
		}
		catch( RecordNotFoundException $ex )
		{
			$settings = new MusicSettings();
			$settings->UserID = $userID;
			$settings->save();
		}

		return $settings;
	}

	public static function GetSettingsForLoggedInUser()
	{
		return self::GetSettingsForUser( (new LoginProvider())->getLoggedInUser()->UniqueIdentifier );
	}
}