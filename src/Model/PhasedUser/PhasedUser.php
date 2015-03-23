<?php
namespace Cant\Phase\Me\Model\PhasedUser;

use Rhubarb\Scaffolds\AuthenticationWithRoles\User;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MediumText;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\Varchar;
use Rhubarb\Stem\Schema\ModelSchema;

class PhasedUser extends User
{
	protected function extendSchema( ModelSchema $schema )
	{
		parent::extendSchema( $schema );

		$schema->addColumn(
			new Varchar( "Username", 150 ),
			new MediumText( "Info" )
		);
	}

}