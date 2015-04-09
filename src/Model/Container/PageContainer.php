<?php
/**
 * How is it going yo
 */

namespace Cant\Phase\Me\Model\Container;


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
			new Varchar( "Url", 255 ),
			new Int( "Priority" )
		);
	}
}