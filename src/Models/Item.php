<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Integer;
use Rhubarb\Stem\Schema\Columns\String;
use Rhubarb\Stem\Schema\ModelSchema;

/**
 * Class Item
 *
 * @package Cant\Phase\Me\Models
 */
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
			new Integer( 'Price', 1 ),
			new Integer( 'LowAlch', 1 ),
			new Integer( 'HighAlch', 1 ),
			new Integer( 'AStab' ),
			new Integer( 'ASlash' ),
			new Integer( 'ACrush' ),
			new Integer( 'AMagic' ),
			new Integer( 'ARange' ),
			new Integer( 'DStab' ),
			new Integer( 'DSlash' ),
			new Integer( 'DCrush' ),
			new Integer( 'DMagic' ),
			new Integer( 'DRange' ),
			new Integer( 'OStrength' ),
			new Integer( 'OPrayer' )
		);

		return $schema;
	}

	public static function createFromCfgLine( $array )
	{
		$obj = new Item();
		$obj->ItemID = $array[ 0 ];
		$obj->Name = $array[ 1 ];
		$obj->Examine = $array[ 2 ];
		$obj->Price = $array[ 3 ];
		$obj->LowAlch = $array[ 4 ];
		$obj->HighAlch = $array[ 5 ];
		$obj->AStab = $array[ 6 ];
		$obj->ASlash = $array[ 7 ];
		$obj->ACrush = $array[ 8 ];
		$obj->AMagic = $array[ 9 ];
		$obj->ARange = $array[ 10 ];
		$obj->DStab = $array[ 11 ];
		$obj->DSlash = $array[ 12 ];
		$obj->DCrush = $array[ 13 ];
		$obj->DMagic = $array[ 14 ];
		$obj->DRange = $array[ 15 ];
		$obj->OStrength = $array[ 16 ];
		$obj->OPrayer = $array[ 17 ];
		$obj->save();
	}
}