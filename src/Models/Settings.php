<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\String;
use Rhubarb\Stem\Schema\ModelSchema;

class Settings extends Model
{
	/**
	 * Cached array of db settings to avoid multiple
	 * database hits for the same things.
	 * @var $cache Array
	 */
	public static $cache;

	protected function createSchema()
	{
		$schema = new ModelSchema( 'tblSettings' );
		$schema->addColumn(
			new AutoIncrement( 'SettingID' ),
			new String( 'Name', 255 ),
			new String( 'Value', 255 )
			);

		return $schema;
	}

	/**
	 * @param        $name
	 * @param string $default
	 *
	 * @return mixed|string
	 */
	public static function get( $name, $default = "" )
	{
		if( isset( self::$cache[ $name ]) )
		{
			return self::$cache[ $name ];
		}
		else
		{
			try
			{
				$setting = Settings::findFirst( new Equals( 'Name', $name ) );
				self::$cache[ $name ] = $setting->Value;
				return $setting->Value;
			}
			catch( RecordNotFoundException $ex )
			{
				self::set( $name, $default );
			}
		}
		return $default;
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @throws \Exception
	 * @throws \Rhubarb\Stem\Exceptions\ModelConsistencyValidationException
	 */
	public static function set( $name, $value )
	{
		try
		{
			$n = self::findFirst( new Equals( 'Name', $name ) );
		}
		catch( RecordNotFoundException $ex )
		{
			$n = new self();
		}
		$n->Name = $name;
		$n->Value = $value;
		$n->save();
	}
}