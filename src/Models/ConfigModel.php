<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Models\Model;

abstract class ConfigModel extends Model
{
	/**
	 * @param $class Model
	 * @param $array
	 *
	 * @throws \Exception
	 * @throws \Rhubarb\Stem\Exceptions\ModelConsistencyValidationException
	 */
	public static function createFromCfgLine( $class, $array )
	{
		$i = 0;
		foreach( $class->getSchema()->getColumns() as $column )
		{
			$name = $column->columnName;
			if( $name != $class->getSchema()->uniqueIdentifierColumnName )
			{
				$class->$name = $array[ $i ];
				$i++;
			}
		}
		$class->save();
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