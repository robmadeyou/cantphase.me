<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Integer;
use Rhubarb\Stem\Schema\ModelSchema;

class NpcDrop extends Model
{
	protected function createSchema()
	{
		$schema = new ModelSchema( 'tblNpcDrop' );
		$schema->addColumn(
			new AutoIncrement( 'NpcDropAutoID' ),
			new Integer( 'NpcID' ),
			new Integer( 'ItemID' ),
			new Integer( 'Amount' ),
			new Integer( 'Rarity' )
		);

		return $schema;
	}
}