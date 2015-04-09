<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Model\Container;


use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Int;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class PageContainer extends Model
{

	/**
	 * Returns the schema for this data object.
	 *
	 * @return \Rhubarb\Stem\Schema\ModelSchema
	 */
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblPageContainer" );
		$schema->addColumn(
			new AutoIncrement( "PageContainerID" ),
			new Varchar( "PageTitle", 255 ),
			new Varchar( "PageName", 255 ),
			new Varchar( "Url", 255 ),
			new Int( "Priority" ),
			new Varchar( "HandlerClass", 512 ),
			new Int( "ParentName" )
		);

		return $schema;
	}

	/**
	 *
	 * Automatically create records if they don't already exist on a Schema update.
	 *
	 * Very useful for automatically setting up databases with pre-set values. With ofcourse, the ability to add even more.
	 * @param $oldVersion
	 * @param $newVersion
	 */
	public static function checkRecords( $oldVersion, $newVersion )
	{
		try
		{
			$page = PageContainer::find( new Equals( "PageName", "Music Player" ) );
		}
		catch( RecordNotFoundException $ex )
		{
			$page = new PageContainer();
		}

	}
}