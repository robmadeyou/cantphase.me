<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Schema\SolutionSchema;

class PhasedSolutionSchema extends SolutionSchema
{
    public function __construct( $version = 0.1021 )
    {
        parent::__construct( $version );

        $this->addModel( 'Item', Item::class );
        $this->addModel( 'Npc', Npc::class );
    }
}