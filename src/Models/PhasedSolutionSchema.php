<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Schema\SolutionSchema;

class PhasedSolutionSchema extends SolutionSchema
{
    public function __construct( $version = 0 )
    {
        parent::__construct( $version );

        $this->registerSchema( 'Item', Item::class );
    }
}