<?php
namespace Cant\Phase\Me\Model\Music\SongModels;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Int;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class Song extends Model
{
	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblSong" );

		$schema->addColumn(
			new AutoIncrement( "SongID" ),
			new ForeignKey( 'AlbumID' ),
			new ForeignKey( 'ArtistID' ),
			new Varchar( "Name", 255 ),
			new Int( "Length" ),
			new Varchar( "Bitrate", 20 ),
			new Varchar( "Format", 20 )
		);

		$schema->labelColumnName = 'Name';

		return $schema;
	}
}