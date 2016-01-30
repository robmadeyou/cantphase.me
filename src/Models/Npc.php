<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Collections\Collection;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Integer;
use Rhubarb\Stem\Schema\Columns\String;
use Rhubarb\Stem\Schema\ModelSchema;

class Npc extends ConfigModel
{
	protected function createSchema()
	{
		$schema = new ModelSchema( 'tblNpc' );

		$schema->addColumn(
			new AutoIncrement( 'NpcAutoID' ),
			new Integer( 'NpcID' ),
			new String( 'NpcName', 200 ),
			new Integer( 'Combat' ),
			new Integer( 'Health' ),
			new Integer( 'SpawnX' ),
			new Integer( 'SpawnY' ),
			new Integer( 'Height' ),
			new Integer( 'Walk' ),
			new Integer( 'MaxHit' ),
			new Integer( 'Attack' ),
			new Integer( 'Defence' ),
			new String( 'Description', 255 )
		);

		return $schema;
	}

	public static function createFromCfgLine( $class, $array )
	{
		parent::createFromCfgLine( new self(), $array );
	}

	/**
	 * @returns Collection
	 */
	public function GetDrops()
	{
		return NpcDrop::find( new Equals( 'NpcID', $this->NpcID ) );
	}

	/**
	 * @returns Int
	 */
	public function GetNumberOfDrops()
	{
		return $this->GetDrops()->count();
	}
}