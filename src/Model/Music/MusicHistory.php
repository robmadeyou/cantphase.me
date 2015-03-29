<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Model\Music;


use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\DateTime;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class MusicHistory extends Model
{

	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblMusicHistory" );

		$schema->addColumn(
			new AutoIncrement( "MusicHistoryID" ),
			new ForeignKey( "UserID" ),
			new ForeignKey( "MusicID" ),
			new DateTime( "RequestedAt" )
		);

		return $schema;
	}
}