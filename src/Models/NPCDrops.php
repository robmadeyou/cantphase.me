<?php

namespace Cant\Phase\Me\Models;

use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Integer;
use Rhubarb\Stem\Schema\Columns\Json;
use Rhubarb\Stem\Schema\ModelSchema;

class NPCDrops extends ConfigModel
{
    protected function createSchema()
    {
        $schema = new ModelSchema( 'tblNpcDrop' );
        $schema->addColumn(
            new AutoIncrement( 'NpcDropAutoID' ),
            new Integer( 'NpcID' ),
            new Json( 'Data', null, true )
        );

        return $schema;
    }

}