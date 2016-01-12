<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Models\Model;

abstract class ConfigModel extends Model
{
	public static function createFromCfgLine( $array )
	{
		$obj = new Item();

		$i = 0;
		foreach( $obj->getSchema()->getColumns() as $column )
		{
			$name = $column->columnName;
			if( $name != $obj->getSchema()->uniqueIdentifierColumnName )
			{
				$obj->$name = $array[ $i ];
				$i++;
			}
		}
		$obj->save();
	}

	/**
	 * Returns a glued single line for the cfg
	 * @return string
	 */
	public function returnSerializableObject()
	{
		$array = [];
		foreach( $this->getSchema()->getColumns() as $column )
		{
			$name = $column->columnName;
			if( $name != $this->getSchema()->uniqueIdentifierColumnName )
			{
				$array[ $column->columnName ] = $this->$name;
			}
		}

		return $array;
	}
}