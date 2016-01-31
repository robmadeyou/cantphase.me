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
class Item extends ConfigModel
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

	public static function createFromCfgLine( $class, $array )
	{
		parent::createFromCfgLine( new self(), $array );
	}

	public function GetImageRealPath()
	{
		return "http://services.runescape.com/m=itemdb_rs/5081_obj_big.gif?id=" . $this->ItemID;
	}

	public function GetImagePath()
	{
		return "http://services.runescape.com/m=itemdb_rs/5081_obj_big.gif?id={$this->ItemID}";
	}

}