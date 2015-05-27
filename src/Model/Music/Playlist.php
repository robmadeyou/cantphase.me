<?php

namespace Cant\Phase\Me\Model\Music;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\MySql;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\DateTime;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Int;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MediumText;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlSchema;

class Playlist extends Model
{
	protected function createSchema()
	{
		$schema = new MySqlSchema( "tblPlaylist" );

		$schema->addColumn(
			new AutoIncrement( "PlaylistID" ),
			new ForeignKey( "UserID" ),
			new Varchar( "Name", 128 ),
			new MediumText( "Description" ),
			new Int( "Rating" ),
			new DateTime( "DateCreated" )
		);

		$schema->labelColumnName = 'Name';

		return $schema;
	}

	protected function beforeSave()
	{
		if( $this->isNewRecord() )
		{
			$this->DateCreated = new \DateTime( 'now' );
		}
		parent::beforeSave();
	}

	public function GetAllMusic()
	{
		
	}
}