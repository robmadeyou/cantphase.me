<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Schema\SolutionSchema;

class PhasedSolutionSchema extends SolutionSchema
{
    public function __construct( $version = 0.1022 )
    {
        parent::__construct( $version );

        $this->addModel( 'Item', Item::class );
        $this->addModel( 'Npc', Npc::class );
        $this->addModel( 'NpcDrop', NpcDrop::class );
        $this->addModel( 'Settings', Settings::class );

    }
}