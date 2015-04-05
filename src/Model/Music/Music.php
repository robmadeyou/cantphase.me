<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Model\Music;


use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\AndGroup;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MediumText;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class Music extends Model
{

	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblMusic" );

		$schema->addColumn(
			new AutoIncrement( "MusicID" ),
			new Varchar( "Url", 256 ),
			new Varchar( "CustomName", 256 ),
			new Varchar( "Genre", 256 ),
			new MediumText( "Notes" ),
			new Varchar( "Name", 256 ),
			new Varchar( "Image", 256 ),
			new Varchar( "Uploader", 256 ),
			new Varchar( "Source", 256 ),
			new ForeignKey( "UserID" )
		);

		$schema->labelColumnName = 'Name';

		return $schema;
	}

	public function IsFavoriteSong( $userID )
	{
		try
		{
			MusicFavorite::findFirst( new AndGroup( [ new Equals( "MusicID", $this->MusicID ), new Equals( "UserID", $userID ) ] ) );
			return true;
		}
		catch( RecordNotFoundException $ex )
		{
			return false;
		}
		return false;
	}
}