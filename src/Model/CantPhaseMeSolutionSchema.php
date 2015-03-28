<?php

namespace Cant\Phase\Me\Model;

use Rhubarb\Stem\Schema\SolutionSchema;

class CantPhaseMeSolutionSchema extends SolutionSchema
{
	public function __construct( )
	{
		parent::__construct( 0.007 );

		$this->addModel( "PhasedUser", __NAMESPACE__ . '\PhasedUser\PhasedUser' );
		$this->addModel( "Music", __NAMESPACE__ . '\Music\Music' );
		$this->addModel( "MusicSettings", __NAMESPACE__ . '\Music\MusicSettings' );

	}

	protected function defineRelationships()
	{
		parent::defineRelationships();
	}
}