<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Boolean;
use Rhubarb\Stem\Schema\Columns\Integer;
use Rhubarb\Stem\Schema\Columns\Json;
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
			new Boolean( 'Stacks' ),
			new Json( 'Food', '{"Edible":false,"Cookable":false,"HealsFor":0}', true),
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

	public function getExamine()
	{
		return str_replace( '_', ' ', $this->modelData[ 'Examine' ] );
	}

	public function setExamine( $examine )
	{
		$this->modelData[ 'Examine' ] = str_replace( ' ', '_', $examine );
	}

	public function getFormattedPrice()
	{
		return number_format( $this->modelData[ 'Price' ] );
	}

	public static function createFromCfgLine( $class, $array )
	{
		parent::createFromCfgLine( new self(), $array );
	}

	public function getImageRealPath()
	{
		return "http://services.runescape.com/m=itemdb_rs/5102_obj_big.gif?id=" . $this->ItemID;
	}

	public function getImagePath()
	{
		return "http://services.runescape.com/m=itemdb_rs/5102_obj_big.gif?id={$this->ItemID}";
	}

}