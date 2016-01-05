<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Integer;
use Rhubarb\Stem\Schema\Columns\String;
use Rhubarb\Stem\Schema\ModelSchema;

class Item extends Model
{
	protected function createSchema()
	{
		$schema = new ModelSchema( 'tblItem' );

		$schema->addColumn(
			new AutoIncrement( 'ItemAutoID' ),
			new Integer( 'ItemID' ),
			new String( 'Name', 200 ),
			new String( 'Examine', 200 ),
			new Integer( 'Price', 1 )
		);

		return $schema;
	}

}