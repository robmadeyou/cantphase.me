<?php
namespace Cant\Phase\Me\Model\Music;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class PlaylistSongs extends Model
{
	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblPlaylistSongs" );

		$schema->addColumn(
			new AutoIncrement( "PlaylistSongsID" ),
			new ForeignKey( "PlaylistID" ),
			new ForeignKey( "MusicID" )
		);

		$schema->labelColumnName = 'Name';

		return $schema;
	}
}