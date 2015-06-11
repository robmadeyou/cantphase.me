<?php
namespace Cant\Phase\Me\Model\Music\SongModels;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class Artist extends Model
{
	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( 'tblArtist' );

		$schema->addColumn(
			new AutoIncrement( 'ArtistID' ),
			new Varchar( 'Name', 150 )
		);

		return $schema;
	}
}