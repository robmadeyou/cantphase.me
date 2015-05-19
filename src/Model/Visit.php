<?php

namespace Cant\Phase\Me\Model;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\DateTime;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class Visit extends Model
{
	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblVisit" );

		$schema->addColumn(
			new AutoIncrement( "VisitID" ),
			new DateTime( "DateTimeVisited" ),
			new Varchar( "IP", 16 ),
			new Varchar( "Url", 256 )
			);

		return $schema;
	}

	public static function newEntry( $ip, $url )
	{
		$a = new Visit();
		$a->DateTimeVisited = new \DateTime( "now" );
		$a->IP = $ip;
		$a->Url = $url;
		$a->save();
	}
}
