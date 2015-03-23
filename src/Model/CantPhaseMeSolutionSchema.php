<?php

namespace Cant\Phase\Me\Model;

use Rhubarb\Stem\Schema\SolutionSchema;

class CantPhaseMeSolutionSchema extends SolutionSchema
{
	public function __construct( )
	{
		parent::__construct( 0.002 );

		$this->addModel( "PhasedUser", __NAMESPACE__ . '\PhasedUser\PhasedUser' );

	}

	protected function defineRelationships()
	{
		parent::defineRelationships();
	}
}